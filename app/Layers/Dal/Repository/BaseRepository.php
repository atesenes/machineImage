<?php

namespace App\Layers\Dal\Repository;

use App\Layers\Dal\Repository\Abs\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function findByCustomColumn($column, $data, $wt = 0)
    {
        if ($wt == 0)
            return $this->model::where($column, $data)->first();
        else if ($wt == 1)
            return $this->model::withTrashed()->where($column, $data)->first();
        else if ($wt == 2)
            return $this->model::onlyTrashed()->where($column, $data)->first();

    }

    public function findByCustomColumns($array = array())
    {
        $query = $this->model;
        foreach ($array as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query->first();
    }

    public function getByColumn($column, $data, $wt = 0)
    {
        if ($wt == 0)
            return $this->model::where($column, $data)->get();
        else if ($wt == 1)
            return $this->model::withTrashed()->where($column, $data)->get();
        else if ($wt == 2)
            return $this->model::onlyTrashed()->where($column, $data)->get();
    }

    public function getByColumnWithPaginate($column, $data, $wt = 0)
    {
        if ($wt == 0)
            return $this->model::where($column, $data)->orderBy('id','desc')->paginate(5);
        else if ($wt == 1)
            return $this->model::withTrashed()->where($column, $data)->orderBy('id','desc')->paginate(5);
        else if ($wt == 2)
            return $this->model::onlyTrashed()->where($column, $data)->orderBy('id','desc')->paginate(5);
    }

    public function getByColumns($array = array(), $wt = 0)
    {

        if($wt == 0)
            $query = $this->model;
        if ($wt == 1)
            $query = $this->model::withTrashed();
        else if ($wt == 2)
            $query = $this->model::onlyTrashed();

        foreach ($array as $key => $value) {
            $query = $query->where($key, $value);
        }

        return $query->get();
    }

    public function all($columns = ['*'], $wt = 0)
    {
        if ($wt == 0)
            return $this->model::all($columns)->sortByDesc("created_at");
        else
            return $this->model::withTrashed()->sortByDesc("created_at")->get();
    }

    public function firstOrCreate($where, $data)
    {

        return $this->model::firstOrCreate($where, $data);
    }

    public function deleteByCustomColumn($column, $data)
    {
        return $this->model::where($column, $data)->delete();
    }

    public function deleteByCustomColumns($array = array())
    {
        $query = $this->model;
        foreach ($array as $key => $value) {
            $query = $query->where($key, $value);
        }

        return $query->delete();
    }


    public function update($id, $data)
    {
        return $this->model::where('id', $id)->update($data);
    }

    public function updateCustomColumn($where, $data)
    {
        return $this->model::where($where)->update($data);
    }

    public function getColumnValuesDistinct($column_name)
    {
        return $this->model::groupBy($column_name)->get();
    }

    public function whereIn($value)
    {
        return $this->model::whereIn($value)->get();
    }

    public function destroy($id)
    {
        return $this->model::destroy($id);
    }

    public function findMax($whereArr, $field)
    {
        return $this->model::where($whereArr)->max($field);
    }

    public function updateOrCreate($where, $data)
    {
        return $this->model::updateOrCreate($where, $data);
    }
    public function restoreByID($id)
    {
       return $this->model::withTrashed()->find($id)->restore();
    }
    public function restoreByWhere($data)
    {
        return $this->model::withTrashed()->where($data)->restore();
    }
    public function findByUUID($uuid)
    {
        return $this->model::where("uuid",$uuid)->first();
    }

    public function updateByCustomColumns($array,$data)
    {
        $query = $this->model;
        foreach ($array as $key => $value) {
            $query = $query->where($key, $value);
        }

        return $query->update($data);
        /*return $this->model->where($array)->update($data);*/
    }

    public function getByColumnDesc($column, $data, $wt = 0)
    {
        if ($wt == 0)
            return $this->model::where($column, $data)->orderBy('id','DESC')->first();
        else if ($wt == 1)
            return $this->model::withTrashed()->where($column, $data)->orderBy('id','DESC')->first();
        else if ($wt == 2)
            return $this->model::onlyTrashed()->where($column, $data)->orderBy('id','DESC')->first();
    }

    public function getByColumnOrderByOrder($column, $data, $wt = 0)
    {
        if ($wt == 0)
            return $this->model::where($column, $data)->orderBy('order','ASC')->get();
        else if ($wt == 1)
            return $this->model::withTrashed()->where($column, $data)->orderBy('order','ASC')->get();
        else if ($wt == 2)
            return $this->model::onlyTrashed()->where($column, $data)->orderBy('order','ASC')->get();
        else if ($wt == 3)
            return $this->model::orderBy('order','DESC')->get();
    }

    public function updateWithModelFind($id,$data){
        $model = $this->model::find($id);
        return $model->update($data);
    }

    public function deleteWithFirstFunction($data){
        $model = $this->model::where($data)->first();
        return $model->delete($data);
    }


}
