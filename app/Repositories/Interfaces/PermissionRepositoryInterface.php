<?php

namespace App\Repositories\Interfaces;

interface PermissionRepositoryInterface
{
    public function pluck();

    public function store($input);

}