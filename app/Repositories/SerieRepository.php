<?php

namespace App\Repositories;

use App\Filters\FilterManager;
use App\Interfaces\SerieRepositoryInterface;
use App\Models\Serie;

class SerieRepository implements SerieRepositoryInterface
{
    public function __construct(protected FilterManager $filterManager)
    {
        //
    }

    public function index(array $filters = [])
    {
        $query = Serie::query();
        $this->filterManager->apply($query, $filters);
        return $query->get();
        //return $query->paginate(1);
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
