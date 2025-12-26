<?php

namespace App\Modules\Shared\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    protected array $searchable;
    protected array $filterable;
    protected array $relations;
    protected array $sortable;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $queryParams = [], ?int $perPage = null)
    {
        $perPage = $perPage ?? env('API_DEFAULT_PER_PAGE', 10);
        $query = $this->model->newQuery();


        // 🔐 Filtro por contexto de usuario
        if (Auth::check() && method_exists($this->model, 'scopeForUser')) {
            $query->forUser(Auth::user());
        }

        if (!empty($queryParams['include'])) {
            $includes = explode(',', $queryParams['include']);
            $validIncludes = array_intersect($includes, $this->relations);
            $query->with($validIncludes);
        }

        if (!empty($queryParams['search']) && !empty($this->searchable)) {
            $search = $queryParams['search'];
            $query->where(function ($q) use ($search) {
                foreach ($this->searchable as $column) {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        if (!empty($queryParams['filter']) && is_array($queryParams['filter'])) {
            foreach ($queryParams['filter'] as $field => $value) {
                if (in_array($field, $this->filterable)) {
                    $query->where($field, $value);
                }
            }
        }

        if (!empty($queryParams['sort'])) {
            $field = ltrim($queryParams['sort'], '-');
            $direction = str_starts_with($queryParams['sort'], '-') ? 'desc' : 'asc';

            if (in_array($field, $this->sortable)) {
                $query->orderBy($field, $direction);
            }
        }

        return $query->paginate($perPage)->appends($queryParams);
    }

    public function find(int $id, array $includes = [])
    {
        $query = $this->model->withTrashed();
        $validIncludes = array_intersect($includes, $this->relations);

        if (!empty($validIncludes)) {
            $query->with($validIncludes);
        }

        return $query->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function restore(int $id)
    {
        return $this->model->withTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete(int $id)
    {
        return $this->model->withTrashed()->findOrFail($id)->forceDelete();
    }
}
