<?php

namespace App\Interfaces;

interface EpisodeRepositoryInterface
{
    public function index(array $filters = []);
    public function getById($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
