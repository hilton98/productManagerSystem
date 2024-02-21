<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Entities\UserEntity;
use App\Domain\UseCases\Interfaces\CreateUserUseCaseInterface;

class CreateUserUseCase implements CreateUserUseCaseInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): array
    {
        try{
            $user = new UserEntity();
            $user->setName($data['name']);
            $user->setEmail($data['email']);
            $user->setPassword(bcrypt($data['password']));
            $this->userRepository->save($user);
            return ['isSuccess' => true, 'message' => "Object created successfully." ];
        } catch (\Exception $e) {
            return ['isSuccess' => false, 'message' => $e->getMessage()];
        }
    }
    
}
