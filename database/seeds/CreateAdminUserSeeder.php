<?php

use Illuminate\Database\Seeder;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

class CreateAdminUserSeeder extends Seeder
{
    private $userRepository;
    private $roleRepository;
    private $permissionRepository;
    private $imageRepository;

    public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository,
                                PermissionRepositoryInterface $permissionRepository, ImageRepositoryInterface $imageRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
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
            'name' => 'Kevin Admin Cho',
            'email' => 'kingservant@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $this->imageRepository->store([
            'user_id' => $user->id,
            'path' => 'testImage'
        ]);

        $role = $this->roleRepository->store(['name' => 'Admin']);

        $permissions = $this->permissionRepository->pluck();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
