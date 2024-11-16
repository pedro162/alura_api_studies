<?php

namespace App\Repositories;

use App\Filters\FilterManager;
use App\Models\User;

class UserRepository
{
    public function __construct(protected FilterManager $filterManager)
    {
        //
    }

    public function index(array $filters = [])
    {
        $query = User::query();
        $this->filterManager->apply($query, $filters);
        return $query->get();
    }

    public function getById($id)
    {
        return User::findOrFail($id);
    }

    public function store(array $data)
    {
        return User::create($data);
    }

    public function update(array $data, $id)
    {
        return User::whereId($id)->update($data);
    }

    public function delete($id)
    {
        User::destroy($id);
    }
}
