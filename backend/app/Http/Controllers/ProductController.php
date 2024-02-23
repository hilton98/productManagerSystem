<?php 

namespace App\Http\Controllers;
use App\Domain\UseCases\UpdateProductUseCase;
use App\Domain\UseCases\CreateProductUseCase;
use App\Domain\UseCases\DeleteProductUseCase;
use App\Domain\UseCases\GetProductUseCase;
use App\Domain\UseCases\GetAllProductsUseCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $updateProductUseCase;
    private $createProductUseCase;
    private $deleteProductUseCase;
    private $getProductUseCase;
    private $getAllProductsUseCase;

    public function __construct(
        UpdateProductUseCase $updateProductUseCase,
        CreateProductUseCase $createProductUseCase,
        DeleteProductUseCase $deleteProductUseCase,
        GetProductUseCase $getProductUseCase,
        GetAllProductsUseCase $getAllProductsUseCase,
    )
    {
        $this->updateProductUseCase = $updateProductUseCase;
        $this->createProductUseCase = $createProductUseCase;
        $this->deleteProductUseCase = $deleteProductUseCase;
        $this->getProductUseCase = $getProductUseCase;
        $this->getAllProductsUseCase = $getAllProductsUseCase;
    }

    public function update(Request $request, int $id)
    {
        $user = Auth::user();
        if(!$user)
            return response()->json(['error' => 'No authorization to update data'], 401);

        $formData = $request->json()->all();
        $result = $this->updateProductUseCase->execute($id, $formData);
        return response()->json($result, $result['isSuccess'] ? 200 : 400);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        if(!$user)
            return response()->json(['error' => 'No authorization to update data'], 401);

        $result = $this->createProductUseCase->execute($request->json()->all());
        if ($result['isSuccess'])
            return response()->json(['success' => $result['message']], 201);

        return response()->json(['error' => $result['message']], 400);
    }

    public function delete(int $id)
    {
        $user = Auth::user();
        if(!$user)
            return response()->json(['error' => 'No authorization to update data'], 401);

        try {
            $product = $this->deleteProductUseCase->execute($id);
            return response()->json(['success' => 'Product removed!'], 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getItemById(int $id)
    {
        $user = Auth::user();
        if(!$user)
            return response()->json(['error' => 'No authorization to update data'], 401);

        try {
            $product = $this->getProductUseCase->execute($id);
            return response($product->toJson());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getAllItems()
    {
        $user = Auth::user();
        if(!$user)
            return response()->json(['error' => 'No authorization to update data'], 401);
        
        try {
            $products = json_encode($this->getAllProductsUseCase->execute());
            return response($products);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

}