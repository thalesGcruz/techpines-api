<?php 

namespace App\Services;

use App\Models\Music;

class MusicService
{
    public function listAll(?string $status = null, int $perPage = 5)
    {
        $query = Music::query();
        if ($status) {
            $query->where('status', $status);
        }

        $query->orderByDesc('views');
        return $query->paginate($perPage);
      
    }

    public function create(array $data): Music
    {
        if (!isset($data['url'])) {
            throw new \InvalidArgumentException("O campo 'url' é obrigatório.");
        }

        $videoId = $this->extractVideoId($data['url']);
        if (!$videoId) {
            throw new \RuntimeException("Não foi possível extrair o ID do vídeo da URL.");
        }

        $videoInfo = $this->getVideoInfo($videoId);

        $musicData = [
            'title'      => $videoInfo['title'],
            'views'      => $videoInfo['views'],
            'youtube_id' => $videoInfo['youtube_id'],
            'thumb'      => $videoInfo['thumb'],
            'status'     => $data['status'] ?? 'active',
        ];

        return Music::create($musicData);
    }

    public function getById(int $id): ? Music
    {
        return Music::find($id);
    }

    public function update(Music $music, array $data): Music
    {
        $music->update($data);
        return $music;
    }

    public function delete(Music $music): void
    {
        $music->delete();
    }

    function extractVideoId(string $url): ?string
    {
        $patterns = [
            '/youtube\.com\/watch\?v=([^&]+)/',
            '/youtu\.be\/([^?]+)/',
            '/youtube\.com\/embed\/([^?]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    function getVideoInfo(string $videoId): array
    {
        $url = "https://www.youtube.com/watch?v=$videoId";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new RuntimeException("Erro ao acessar o YouTube: " . curl_error($ch));
        }
        curl_close($ch);

        if (!preg_match('/<title>(.+?) - YouTube<\/title>/', $response, $titleMatches)) {
            throw new RuntimeException("Não foi possível encontrar o título do vídeo");
        }
        $title = html_entity_decode($titleMatches[1], ENT_QUOTES);

        $views = 0;
        if (preg_match('/"viewCount":\s*"(\d+)"/', $response, $viewMatches)) {
            $views = (int)$viewMatches[1];
        } elseif (preg_match('/\"viewCount\"\s*:\s*{.*?\"simpleText\"\s*:\s*\"([\d,\.]+)\"/', $response, $viewMatches)) {
            $views = (int)str_replace(['.', ','], '', $viewMatches[1]);
        }

        return [
            'title' => $title,
            'views' => $views,
            'youtube_id' => $videoId,
            'thumb' => "https://img.youtube.com/vi/$videoId/hqdefault.jpg",
        ];
    }

}