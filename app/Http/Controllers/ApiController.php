<?php

namespace App\Http\Controllers;

use App\Layers\Bal\Service\ImageService;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    //
    private $image_service;

    public function __construct(ImageService $imageService)
    {
        $this->image_service = $imageService;
    }

    //Get all images
    public function index()
    {
        return $this->image_service->getList();
    }
    //Get single image
    public function show($id)
    {
        return $this->image_service->getImage($id);
    }

}
