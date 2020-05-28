<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Imagick;
use ZipArchive;
use Illuminate\Support\Carbon;

class ConversorController extends Controller
{
    //
    public function vista(){

        $files = sizeof(glob(public_path('storage/pdf/*')));
        if ($files>=1){                                                         //si hay archivos en la carpeta de pdfs, se eliminan al cargar la vista
            $files = glob(public_path('storage/pdf/*'));
            foreach($files as $file){
                unlink($file);
            }
        }

        $files = sizeof(glob(public_path('storage/image/*')));
        if ($files>=1){                                                         //si hay archivos en la carpeta de image, se eliminan al cargar la vista
            $files = glob(public_path('storage/image/*'));
            foreach($files as $file){
                unlink($file);
            }
        }

        $files = sizeof(glob(public_path('storage/zip/*')));
        if ($files>=1){                                                         //si hay archivos en la carpeta de zip, se eliminan al cargar la vista
            $files = glob(public_path('storage/zip/*'));
            foreach($files as $file){
                unlink($file);
            }
        }

        return view('welcome');
    }
    public function save(Request $request){
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('storage/image'),$imageName);                  //almacenamos, con el nombre original, el archivo en image
        return response()->json(['success'=>$imageName]);
    }
    public function download(){

        $files = sizeof(glob(public_path('storage/pdf/*')));                    //eliminamos los archivos en la carpeta de pdf
        if ($files>=1){                                                         //si hay archivos en la carpeta de pdfs
            $files = glob(public_path('storage/pdf/*'));
            foreach($files as $file){                                           //se eliminaran todos los archivos en la carpeta pdf
                unlink($file);
            }
        }

        $files = glob(public_path('storage/image/*'));                          //transformamos las imagenes
        foreach($files as $file){                                               //se eliminaran todos los archivos en la carpeta pdf
            $image = new Imagick($file);
            $image->setImageFormat('pdf');                                      //lo transformamos a pdf
            $imageName= substr($file,44);
            $image->writeImage(public_path('storage/pdf/'.substr($imageName,0,-4).'.pdf'));//almacenamos el nuevo archivo pdf
            unlink(public_path('storage/image/'.$imageName));                   //eliminamos el archivo en images
        }

        $files = sizeof(glob(public_path('storage/pdf/*')));
        if($files==1){                                                          //si se encuentra solo un archivo pdf, se bajara tal y como esta
            $headers = ['Content-Type' => 'application/pdf',];
            $filename = array_slice(scandir(public_path('storage/pdf')), 2);
            $file=(glob(public_path('storage/pdf/*')));
            return response()->download($file[0], $filename[0], $headers);      //se descarga el archivo
        }

        else if ($files>=2){                                                    //si son mas de dos archivos se van a agregar a un zip
            $files = sizeof(glob(public_path('storage/zip/*')));                //eliminamos los archivos en la carpeta de zip
            if ($files>=1){                                                     //si hay archivos en la carpeta de zip
                $files = glob(public_path('storage/zip/*'));
                foreach($files as $file){                                       //se eliminaran todos los archivos en la carpeta zip
                    unlink($file);
                }
            }

            $zip = new ZipArchive();//inicializamos el zip
            $filename=public_path('storage/zip/'.Carbon::now()->format('Y-m-d_H:i').'.zip');//creamos el archivo zip
            if($zip->open($filename,ZIPARCHIVE::CREATE)===true){
                $files = glob(public_path('storage/pdf/*'));//agregamos todos los archivos al zip
                foreach($files as $file){
                    $zip->addFile($file);
                }
                $zip->close();
                foreach($files as $file){//eliminamos los archivos en pdf
                    if(is_file($file))
                        unlink($file);
                }
                $headers = ['Content-Type' => 'application/pdf',];
                return response()->download($filename,substr($filename,42), $headers);
            }
        }

        else if ($files==0){                                                    //cuando no haya archivos en la carpeta de pdf
            return response()->json(['error'=> 'no ha subido imagenes nuevas imagenes']);
        }
    }
    public function delete(Request $request){
        $name = $request->name;                                                 //elimina del server las imagenes cuando se borran en el dropzone
        unlink(public_path('storage/image/'.$name));
    }
}
