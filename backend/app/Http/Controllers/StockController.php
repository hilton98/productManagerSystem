<?php

namespace App\Http\Controllers;
use App\Domain\UseCases\GetStockUseCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StockController extends Controller
{
    private $getStockUseCase;

    public function __construct(GetStockUseCase $getStockUseCase)
    {
        $this->getStockUseCase = $getStockUseCase;
    }

    public function getStock()
    {
      $user = Auth::user();
      if(!$user)
        return response()->json(['error' => 'No authorization get data'], 401);
      try {
          $stock = json_encode($this->getStockUseCase->execute($user->id));
          return response($stock);
      } catch (\Exception $e) {
          return response()->json(['error' => $e->getMessage()], 404);
      }
    }
}