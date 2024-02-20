<?php 

namespace App\Http\Controllers;
use App\Domain\UseCases\CreateProductUseCase;
use App\Domain\UseCases\UpdateProductUseCase;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $createProductUseCase;
    private $updateProductUseCase;

    public function __construct(
        UpdateProductUseCase $updateProductUseCase,
        CreateProductUseCase $createProductUseCase,
    )
    {
        $this->updateProductUseCase = $updateProductUseCase;
        $this->createProductUseCase = $createProductUseCase;
    }

    public function create(Request $request)
    {
        $product = $this->createProductUseCase->execute($request->json()->all());
        return response()->json('Created', 201);
    }

    public function update(Request $request, int $id)
    {
        $formData = $request->json()->all();
        $result = $this->updateProductUseCase->execute($id, $formData);
        return response()->json($result, $result['isSuccess'] ? 200 : 400);
    }

}