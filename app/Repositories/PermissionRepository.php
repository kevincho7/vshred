<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function pluck()
    {
        return Permission::pluck('id','id')->all();
    }

    public function store($input)
    {
        return Permission::create($input);
    }
}