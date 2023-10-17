<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function store(Request $request)
    {
      $url = $this->upload($request);
      if ($url) {
        return response()->json([
            'success' => true,
            'url' => $url
        ]);
    } else {
        return response()->json(['error' => true, 'url' => $url]);
    }
    }
    public function upload($request){
        if($request->hasFile('file')){
         
            $name = $request->file('file')->getClientOriginalName();
            $pathFull =  'uploads/' . date("Y/m/d");
            $request->file('file')->storeAs(
                'public/' . $pathFull,
                $name
            );
            return 'storage/uploads/' . date("Y/m/d") . '/' . $name;
        }
    }
}
