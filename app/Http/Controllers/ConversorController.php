<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Imagick;
use ZipArchive;

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
        $files = sizeof(glob(public_path('storage/pdf/*')));
        if($files==1){
            $headers = ['Content-Type' => 'application/pdf',];
            $filename = array_slice(scandir(public_path('storage/pdf')), 2);
            $file=(glob(public_path('storage/pdf/*')));
            return response()->download($file[0], $filename[0], $headers);
        }
        else if ($files>=2){
            unlink(public_path('storage/zip/test.zip'));
            $zip = new ZipArchive();
            $filename=public_path('storage/zip/test.zip');
            if($zip->open($filename,ZIPARCHIVE::CREATE)===true){
                $files = glob(public_path('storage/pdf/*'));
                foreach($files as $file){
                    $zip->addFile($file);
                }
                $zip->close();
                foreach($files as $file){
                    if(is_file($file))
                        unlink($file); // delete file
                }
                $headers = ['Content-Type' => 'application/pdf',];
                return response()->download(public_path('storage/zip/test.zip'),'test.zip', $headers);
            }

        }
        else if ($files==0){
            return response()->json(['error'=> 'no hay imagenes']);
        }
    }
}

/* //Borra los archivos de la carpeta de los pdfs
public function download(){
    $files = glob(public_path('storage/pdf/*'));
    foreach($files as $file){ // iterate files
        if(is_file($file))
          unlink($file); // delete file
      }
    dd($files);

} */
