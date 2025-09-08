<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMusicRequest;
use App\Http\Resources\MusicResource;
use App\Services\MusicService;
use App\Helpers\ApiResponse;

class SuggestController extends Controller
{
    protected MusicService $service;

    public function __construct(MusicService $service)
    {
        $this->service = $service;
    }

    public function store(StoreMusicRequest $request){
        $data = $request->validated();
        $data["status"] = "awaiting_approval";
        $music = $this->service->create($data);
        return ApiResponse::success(new MusicResource($music), 'Sugestão enviada com sucesso', 201);
    }

}
