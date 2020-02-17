<?php

namespace App\Repositories\Interfaces;

use App\User;

interface UserRepositoryInterface
{
    public function all();

    public function store($input);

    public function show($id);

    public function update($input, $id);

    public function delete($id);
}