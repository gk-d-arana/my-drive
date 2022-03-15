<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use PDO;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     // public function index()
    // {
    //     return view('home', ["users" => User::all()]);
    // }

    public function index()
    {
        return view('show_files', ["files" => File::all()]);
    }

}
