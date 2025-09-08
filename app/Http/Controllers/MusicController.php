<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Http\Requests\StoreMusicRequest;
use App\Http\Requests\UpdateMusicRequest;
use App\Http\Resources\MusicResource;
use App\Services\MusicService;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    protected MusicService $service;

    public function __construct(MusicService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $status  = $request->query('status');   
        $perPage = (int) $request->query('per_page', 10);
        $musics = $this->service->listAll($status, $perPage);
        return ApiResponse::success($musics);
    }

    public function store(StoreMusicRequest $request)
    {
        $music = $this->service->create($request->validated());
        return ApiResponse::success(new MusicResource($music), 'Musica criado com sucesso', 201);
    }

    public function show(Music $music)
    {
        return ApiResponse::success(new MusicResource($music));
    }

    public function update(UpdateMusicRequest $request, Music $music)
    {
        $music = $this->service->update($music, $request->validated());
        return ApiResponse::success(new MusicResource($music), 'Musica atualizado com sucesso');
    }

    public function destroy(Music $music)
    {
        $this->service->delete($music);
        return ApiResponse::success(null, 'Musica removido com sucesso', 204);
    }

}
