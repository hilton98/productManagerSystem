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
        $result = $this->updateProductUseCase->execute($id, $user->id, $formData);
        return response()->json($result, $result['isSuccess'] ? 200 : 400);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        if(!$user)
            return response()->json(['error' => 'No user!'], 401);

        $result = $this->createProductUseCase->execute($request->json()->all(), $user->id);
        if ($result['isSuccess'])
            return response()->json(['success' => $result['message']], 201);

        return response()->json(['error' => $result['message']], 400);
    }

    public function delete(int $id)
    {
        $user = Auth::user();
        if(!$user)
            return response()->json(['message' => 'No user'], 401);

        try {
            $result = $this->deleteProductUseCase->execute($id, $user->id);
            return response()->json(
                ['message' => $result['message']],
                $result['isSuccess'] ? 204 : 401
            );
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function getItemById(int $id)
    {
        try {
            $product = $this->getProductUseCase->execute($id);
            return response($product->toJson());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getAllItems()
    {
        try {
            $products = json_encode($this->getAllProductsUseCase->execute());
            return response($products);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

}