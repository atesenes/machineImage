<?php

namespace App\Http\Controllers;

use App\Layers\Bal\Service\ImageService;
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
        $data['record'] = $this->image_service->getImage($id);
        return view("image.edit",$data);
    }
    public function show()
    {
        return redirect()->route('home');
    }
    public function store(Request $request)
    {
        //Image store
        $data = $request->only('image');
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
            $file-> move(public_path('images'), $filename);
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
    //Image sortable function
    public function reOrder(Request $request)
    {
        //Image order and ve new order
        $data = $request->only('old','new');
        $order = (int)$data['old'];
        $newOrder = (int)$data['new'];

        return $this->image_service->reOrder($order,$newOrder);

        if ($order>$newOrder)
            return 'Selected moved backwards. Update previous order';
        else
            return 'The chosen one has moved forward. Update next order';

    }
    //save image in cropjs and move image under 'images'
    public function savePicture(Request $request)
    {
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        if ($image_type == "png" || $image_type == "jpg" || $image_type == "jpeg")
        {
            $image_base64 = base64_decode($image_parts[1]);
            $newName = uniqid() . '.'.$image_type;
            $file = "images/". $newName;

            file_put_contents($file,$image_base64);
            return response()->json(['success'=>1,'thumbnail_image' => asset($file),'image_path' => $newName ]);
        }else
        {
            return response()->json(['success'=>0,'message' => 'Lütfen jpg,jpeg,png türünde resim ekleyin']);
        }
    }
}
