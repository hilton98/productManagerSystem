<?php 

namespace App\Domain\UseCases;
use App\Domain\UseCases\Interfaces\ImageStorageUseCaseInterface;

class ImageStorageUseCase implements ImageStorageUseCaseInterface
{
    public function execute(string $data): string
    {
        $imageDecoded = base64_decode($data);
        $imageName = uniqid() . '_' . time() . '.jpeg';        
        $storagePath = public_path('images');        
        file_put_contents($storagePath . '/' . $imageName, $imageDecoded);
        return $imageName;
    }
}
