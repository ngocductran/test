<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function imgupload(Request $request)
    {
        if($request->hasFile('upload')) {
            $origin_Name = $request->file('upload')->getClientOriginalName();
            $File_Name = pathinfo($origin_Name, PATHINFO_FILENAME);
            $extension_Name = $request->file('upload')->getClientOriginalExtension();
            $File_Name = $File_Name.'_'.time().'.'.$extension_Name;
        
            $request->file('upload')->move(public_path('images'), $File_Name);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$File_Name); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
}
