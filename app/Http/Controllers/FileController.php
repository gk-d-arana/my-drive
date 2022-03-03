<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;

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
}
