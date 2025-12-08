<?php

namespace App\Modules\Shared\Infrastructure\Repositories;

interface BaseRepositoryInterface
{
    public function all(array $queryParams = [], ?int $perPage = null);
    public function find(int $id, array $includes = []);
    public function create(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
    public function restore(int $id);
    public function forceDelete(int $id);
}
