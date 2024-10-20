<?php

namespace App\Repositories;

use App\Interfaces\SerieRepositoryInterface;
use App\Models\Serie;

class SerieRepository implements SerieRepositoryInterface
{
    public function index()
    {
        return Serie::all();
    }
    public function getById($id)
    {
        return Serie::findOrFail($id);
    }
    public function store(array $data)
    {
        return Serie::create($data);
    }
    public function update(array $data, $id)
    {
        return Serie::whereId($id)->update($data);
    }
    public function delete($id)
    {
        Serie::destroy($id);
    }
}
