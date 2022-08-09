<?php

namespace App\Layers\Bal\Service;

use App\Layers\Dal\Repository\ImageRepository;

class ImageService
{

    private $repository;
    public function __construct(ImageRepository $imageRepository)
    {
        $this->repository = $imageRepository;
    }
    public function getList()
    {
        return $this->repository->getList();
    }
    public function getImage($id)
    {
        return $this->repository->find($id);
    }
    public function addImage($data)
    {
        $data['order'] = $this->repository->findMax([],'order')+1;
        return $this->repository->create($data);
    }
    public function updateImage($id,$data)
    {
        return $this->repository->update($id,$data);
    }
    public function updateOrder($id,$order)
    {
        return $this->repository->update($id,['order'=>$order]);
    }
    public function deleteImage($id)
    {
        $image = $this->getImage($id);
        $count = $image->order;
        $lists = $this->repository->reOrder($count+1,$this->repository->findMax([],'order'));
        foreach ($lists as $list)
        {
            $this->updateOrder($list->id,$count);
            $count++;
        }
        $this->updateOrder($id,0);
        return $this->repository->delete($id);
    }
    public function getLikeName($name)
    {
        return $this->repository->whereLikeName($name);
    }
    public function reOrder($order,$newOrder)
    {
        //max değerden büyük order no gelirse; En sona gönder
        if ($this->repository->findMax([],'order') < $newOrder)
        {
            $newOrder = $this->repository->findMax([],'order');
        }
        $sortStart = 0;
        if ($order<$newOrder)
        {
            $sortStart = $order;
            $lists = $this->repository->reOrder($order,$newOrder);
        }
        else // new < order
        {
            $sortStart = $newOrder+1;
            $lists = $this->repository->reOrder($newOrder,$order);
        }
        foreach ($lists as $list) {
            if ($list->order == $order)
            {
                $this->updateOrder($list->id,$newOrder);
            }
            else
            {
                $this->updateOrder($list->id,$sortStart);
                $sortStart++;
            }
        }

        return $lists;

    }
}
