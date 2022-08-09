<?php

namespace App\Http\Controllers;

use App\Layers\Bal\Service\ImageService;
use App\Models\Image;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller as BaseController;

class ImageController extends BaseController
{
    //
    private $image_service;

    public function __construct(ImageService $imageService)
    {
        $this->image_service = $imageService;
    }

    public function index()
    {
        $data['records'] = $this->image_service->getList();
        return view("image.index",$data);
    }
    public function create()
    {
        $data['records'] = $this->image_service->getList();
        return view('image.create',$data);
    }
    public function edit($id)
    {
        $data['record'] = Image::find($id);
        return view("image.create",$data);
    }
    public function store(Request $request)
    {
        $data = $request->only('name');
        if($request->hasFile('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
            $data['image']= $filename;
        }
        $newRecord = $this->image_service->addImage($data);
        if ($newRecord)
            Alert::info('Image Uploaded');
        else
            Alert::error('Ohh Sorry');

        return redirect()->route('home');
    }

    public function update(Request $request,$id)
    {
        $data = $request->only('name');
        if($request->hasFile('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/Image'), $filename);
            $data['image']= $filename;
        }
        $updateRecord = $this->image_service->updateImage($id,$data);
        if ($updateRecord)
            Alert::info('Image Updated');
        else
            Alert::error('Ohh Sorry');

        return redirect()->route('home');
    }
    public function destroy($id)
    {
        $deleteRecord = $this->image_service->deleteImage($id);
        if ($deleteRecord)
            Alert::info('Image Deleted');
        else
            Alert::error('Ohh Sorry');

        return redirect()->route('home');
    }
    public function reOrder(Request $request)
    {
        $data = $request->only('old','new');
        $order = (int)$data['old'];
        $newOrder = (int)$data['new'];

        return $this->image_service->reOrder($order,$newOrder);

        if ($order>$newOrder)
            return 'Seçilen geriye taşımış. Öncesinin orderını güncelle';
        else
            return 'Seçilen ileriye taşımış. Sonrasının orderını güncelle';

    }
}
