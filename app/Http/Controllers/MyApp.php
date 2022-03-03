<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class MyApp extends Controller{





    public function login(Request $request){
        if($request->is_new){
            try{
        $user = User::firstWhere('name', $request->name);
        if($user){
            return response([
                "message" => "Username Already Used"
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = User::create([
            'name' =>$request->name,
            'show_password' =>$request->password,
            'password' => Hash::make($request->password),
        ]);
        return response([
            'token' => $user->createToken('tokens')->plainTextToken,
        ]);
            }
            catch(Exception $e){
                $user = User::create([
                    'name' =>$request->name,
                    'show_password' =>$request->password,
                    'password' => Hash::make($request->password),
                ]);
                return response([
                    'token' => $user->createToken('tokens')->plainTextToken,
                ]);
            }
        }
        if(!Auth::attempt($request->only('name', 'password'))){
            return response([
                "message" => "Wrong Credentials"
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
            return response([
                'token' => $user->createToken('tokens')->plainTextToken,
            ]);

    }





















    public function my_files(Request $request){
        $user = $request->user;
        $files = $user->files;
        return response([
            'files' => $files
        ]);
    }

    public function upload_file(Request $request){
        try{
            $validated = $request->validate([
            'name' => 'required|unique:files,name',
            'file' => 'required|file',
        ]);
    }
    catch(Exception $e){
        return response([
            "message" => $e->getMessage()
        ], Response::HTTP_BAD_REQUEST);
    }

        $path = $request->file('file')->store(
            $request->user->name, 'public'
        );

        File::create([
            "user_id" => $request->user->id,
            "name" => $validated['name'],
            "file" => $path
        ]);
        return response([
            'file_path' => $path
        ], Response::HTTP_CREATED);
    }

}
