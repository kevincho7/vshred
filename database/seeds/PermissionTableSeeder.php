<?php

use Illuminate\Database\Seeder;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionTableSeeder extends Seeder
{
    private $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete'
        ];

        foreach ($permissions as $permission) {
            $this->permissionRepository->store(['name' => $permission]);
        }
    }
}
