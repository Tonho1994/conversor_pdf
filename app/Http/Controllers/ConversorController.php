<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Imagick;

class ConversorController extends Controller
{
    //
    public function vista(){
        return view('conversor');
    }
    public function save(Request $request){
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('storage/image'),$imageName);
        $file = public_path('storage/image/'.$imageName);
        $image = new Imagick($file);
        $image->setImageFormat('pdf');
        $image->writeImage(public_path('storage/pdf/'.substr($imageName,0,-4).'.pdf'));
        unlink(public_path('storage/image/'.$imageName));
        return response()->json(['success'=>$imageName]);
    }
    public function download(){
        $files = array_slice(scandir(public_path('storage/pdf')), 2);
        dd($files);

    }
}
