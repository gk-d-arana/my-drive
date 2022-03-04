<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\File as SysFile;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show($id)
    {
        $user = User::firstWhere('id', $id);
        $files = $user->files;
        return view('show_files', ["files"=>$files]);
    }

    public function destroy($id){
        $file = File::find($id)->first();
        $folderPath=public_path("\storage\\". $file->file);
        unlink($folderPath);
        $user_id = $file->user_id;
        $file->delete();
        $path = '/user/' . $user_id . '/files';
        return redirect($path)->with('danger','Deleted Successfully');
    }
}
