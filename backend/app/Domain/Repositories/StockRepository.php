<?php

namespace App\Domain\Repositories;
use App\Domain\Mappers\StockMapper;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;

class StockRepository implements StockRepositoryInterface
{
  public function findByUserId(int $userId)
  {
    $itemsQueried = Stock::join('products', 'stocks.product_id', '=', 'products.id')
    ->where('stocks.user_id', $userId)
    ->select('stocks.*', 'products.name as product_name', 'products.price')
    ->get();    
    if($itemsQueried){
      #TODO Create mapper to stock 
      return $itemsQueried;
    }
    return null;
  }

  public function save(int $userId, int $productId)
  {
    try {
      $model = new Stock;
      $model->user_id = $userId;
      $model->product_id = $productId;
      $model->save();
    } catch (\Exception $e) {
      \Log::error('Error registering stock: ' . $e->getMessage());
      throw new \Exception('Error registering stock: ' . $e->getMessage(), $e->getCode(), $e);       
    }
  }

  public function delete(int $id): bool
  {
    try{
      $itemQueried = Stock::where('product_id', $id)->firstOrFail();
      $itemQueried->delete();
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }

}