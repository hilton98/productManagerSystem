<?php

namespace App\Domain\Repositories;
use App\Domain\Mappers\StockMapper;
use App\Models\Stock;

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
}