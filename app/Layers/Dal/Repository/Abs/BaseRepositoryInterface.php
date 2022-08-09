<?php

namespace App\Layers\Dal\Repository\Abs;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model;

    function delete($id);

    function findByCustomColumn($column, $data);

    function getByColumn($column, $data);

    function getByColumns($array = array());

    function all($columns = ['*']);
    function firstOrCreate($where, $data);
    function deleteByCustomColumn($column, $data);
    function update($id, $data);
    function getColumnValuesDistinct($column_name);
    function whereIn($value);
    function destroy($id);


}
