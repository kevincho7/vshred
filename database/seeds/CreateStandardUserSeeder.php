<?php

use Illuminate\Database\Seeder;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

class CreateStandardUserSeeder extends Seeder
{
    private $userRepository;
    private $imageRepository;

    public function __construct(UserRepositoryInterface $userRepository, ImageRepositoryInterface $imageRepository)
    {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = $this->userRepository->store([
            'name' => 'Kevin Standard Cho',
            'email' => 'kevin@example.com',
            'password' => bcrypt('123456')
        ]);

        $this->imageRepository->store([
            'user_id' => $user->id,
            'path' => 'testImage2'
        ]);
    }
}
