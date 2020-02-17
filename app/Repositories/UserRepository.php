<?php

namespace App\Repositories;

use App\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters('email')
            ->allowedIncludes('images')
            ->get();
    }

    public function store($input)
    {
        return User::create($input);
    }

    public function show($id)
    {
        return QueryBuilder::for(User::class)
            ->allowedIncludes('images')
            ->find($id);
    }

    public function update($input, $id)
    {
        $user = QueryBuilder::for(User::class)
            ->allowedIncludes('images')
            ->find($id);

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->save();

        return $user;
    }

    public function delete($id)
    {
        $user = QueryBuilder::for(User::class)
            ->allowedIncludes('images')
            ->find($id);

        $user->delete();
    }
}