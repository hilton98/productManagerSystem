<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Domain\UseCases\CreateUserUseCase;


class UserController extends Controller
{
    private $createUserUseCase;

    public function __construct( CreateUserUseCase $createUserUseCase ){
        $this->createUserUseCase = $createUserUseCase;
    }

    public function create(Request $request)
    {
        $result = $this->createUserUseCase->execute($request->json()->all());
        if ($result['isSuccess'])
            return response()->json(['success' => $result['message']], 201);
        return response()->json(['error' => $result['message']], 400);
    }
}
