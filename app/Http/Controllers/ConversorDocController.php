<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ConversorDocController extends Controller
{
    //
    public function vista(){
        return view('docx');
    }
    public function save(Request $request){
        $doc = $request->file('file');
        $docName = Carbon::now()->format('Y-m-d_H:i').'.'.$doc->getClientOriginalExtension();
        $doc->move(public_path('storage/doc'),$docName);
        return response()->json(['success'=>$docName]);
    }
    public function download(){
        $files = sizeof(glob(public_path('storage/doc/*')));
        if($files==1){
            $headers = ['Content-Type' => 'application/pdf',];
            $file=glob(public_path('storage/doc/*'));
            $filename = substr($file[0], 42,-4);

            try {
                exec('unoconv -o '.public_path('storage/pdf/').$filename.' '.$file[0]);
                unlink($file[0]);
            } catch (\Throwable $th) {
               dd($th);
            }
            $file=glob(public_path('storage/pdf/*'));
            return response()->download($file[0], $filename.'.pdf', $headers);
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
