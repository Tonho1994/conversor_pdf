<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Carbon;

class ConversorDocController extends Controller
{
    //
    public function vista(){

        $files = sizeof(glob(public_path('storage/doc/*')));
        if ($files>=1){                                                         //si hay archivos en la carpeta de doc, se eliminan al cargar la vista
            $files = glob(public_path('storage/doc/*'));
            foreach($files as $file){
                unlink($file);
            }
        }

        $files = sizeof(glob(public_path('storage/pdf/*')));
        if ($files>=1){                                                         //si hay archivos en la carpeta de pdfs, se eliminan al cargar la vista
            $files = glob(public_path('storage/pdf/*'));
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

        return view('docx');
    }
    public function save(Request $request){
        $doc = $request->file('file');
        $docName = $doc->getClientOriginalName();
        //$docName = Carbon::now()->format('Y-m-d_H:i').'.'.$doc->getClientOriginalExtension();
        $doc->move(public_path('storage/doc'),$docName);
        return response()->json(['success'=>$docName]);
    }
    public function download(){

        $files = sizeof(glob(public_path('storage/pdf/*')));                    //eliminamos los archivos en la carpeta de pdf
        if ($files>=1){                                                         //si hay archivos en la carpeta de pdfs
            $files = glob(public_path('storage/pdf/*'));
            foreach($files as $file){                                           //se eliminaran todos los archivos en la carpeta pdf
                unlink($file);
            }
        }

        $files = glob(public_path('storage/doc/*'));                          //transformamos las imagenes
        foreach($files as $file){                                               //se eliminaran todos los archivos en la carpeta pdf

            $filename = substr($file,42,-4);

            try {
                exec('unoconv -o '.public_path('storage/pdf/').$filename.' '.$file);
                unlink($file);
            } catch (\Throwable $th) {
                dd($th);
            }
        }

        $files = sizeof(glob(public_path('storage/pdf/*')));
        if($files==1){                                                          //si se encuentra solo un archivo pdf, se bajara tal y como esta
            $headers = ['Content-Type' => 'application/pdf',];
            $file=glob(public_path('storage/pdf/*'));
            $filename = substr($file[0], 42,-4);
            return response()->download($file[0], $filename.'.pdf', $headers);  //se descarga el archivo
        }

        else if ($files>=2){                                                    //si son mas de dos archivos se van a agregar a un zip
            $files = sizeof(glob(public_path('storage/zip/*')));                //eliminamos los archivos en la carpeta de zip
            if ($files>=1){                                                     //si hay archivos en la carpeta de zip
                $files = glob(public_path('storage/zip/*'));
                foreach($files as $file){                                       //se eliminaran todos los archivos en la carpeta zip
                    unlink($file);
                }
            }

            $zip = new ZipArchive();                                            //inicializamos el zip
            $filename=public_path('storage/zip/'.Carbon::now()->format('Y-m-d_H:i').'.zip');//creamos el archivo zip
            if($zip->open($filename,ZIPARCHIVE::CREATE)===true){
                $files = glob(public_path('storage/pdf/*'));                    //agregamos todos los archivos al zip
                foreach($files as $file){
                    $zip->addFile($file);
                }
                $zip->close();
                foreach($files as $file){                                       //eliminamos los archivos tipo documento
                    if(is_file($file))
                        unlink($file);
                }
                $headers = ['Content-Type' => 'application/pdf',];
                return response()->download($filename,substr($filename,42), $headers);
            }
        }

        else if ($files==0){                                                    //cuando no haya archivos en la carpeta de doc
            return response()->json(['error'=> 'no ha subido documentos nuevos']);
        }
    }
    public function delete(Request $request){
        $name = $request->name;                                                 //elimina del server los documentos cuando se borran en el dropzone
        unlink(public_path('storage/doc/'.$name));
    }
}
