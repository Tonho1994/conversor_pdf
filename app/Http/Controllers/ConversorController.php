<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Imagick;

class ConversorController extends Controller
{
    //
    public function vista(){
        return view('conversor');
    }
    public function save(Request $request){
        $image = $request->file('file');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('storage/image'),$imageName);
        return response()->json(['success'=>$imageName]);
    }
}
