<?php

namespace App\Layers\Dal\Repository;

use App\Models\Image;


class ImageRepository extends BaseRepository
{


    public function __construct(Image $model)
    {
        parent::__construct($model);
    }
    public function getImage($id)
    {
        return $this->model->find($id);
    }
    public function getList()
    {
        return $this->model::orderBy('order','ASC')->get();
    }
    public function getBetweenTwoOrder($start,$finish)
    {
        return $this->model::whereBetween('order',[$start,$finish])->orderBy('order','ASC')->get();
    }
}
