<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class MyApp extends Controller{
    public function login(Request $request)
    {
        if ($request->is_new) {
            try {
                $user = User::firstWhere('name', $request->name);
                if ($user) {
                    return response([
                        "message" => "Username Already Used"
                    ], Response::HTTP_BAD_REQUEST);
                }
                $user = User::create([
                    'name' => $request->name,
                    'show_password' => $request->password,
                    'password' => Hash::make($request->password),
                ]);
                return response([
                    'token' => $user->createToken('tokens')->plainTextToken,
                ]);
            } catch (Exception $e) {
                $user = User::create([
                    'name' => $request->name,
                    'show_password' => $request->password,
                    'password' => Hash::make($request->password),
                ]);
                return response([
                    'token' => $user->createToken('tokens')->plainTextToken,
                ]);
            }
        }
        if (!Auth::attempt($request->only('name', 'password'))) {
            return response([
                "message" => "Wrong Credentials"
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        return response([
            'token' => $user->createToken('tokens')->plainTextToken,
        ]);
    }



    public function my_files(Request $request)
    {
        $user = $request->user;
        $files = $user->files;
        foreach ($files as $file) {
            // $file->created_at = \Carbon\Carbon::parse($file->created_at)->format('Y-d-M G:i:s');
            $file->created_at->format('Y-d-M G:i:s');
            $file->save();
        }
        return response([
            'files' => $files
        ]);
    }


    public function delete_file($id)
    {
        $file = File::findOrFail($id);
        $folderPath=public_path("\storage\\". $file->file);
        try{unlink($folderPath);}catch(Exception $e){}
        $file->delete();
        return response([
            "message" => "success"
        ]);
    }

    public function my_upload_file(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:files,name',
                'file' => 'required|string',
            ]);
        } catch (Exception $e) {
            return response([
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        $image_64 = $validated['file']; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

      // find substring fro replace here eg: data:image/png;base64,

       $image = str_replace($replace, '', $image_64);

       $image = str_replace(' ', '+', $image);

       $imageName = Str::random(10).'.'.$extension;

       Storage::disk('public')->put($imageName, base64_decode($image));

        $path = $imageName;

        $file = File::create([
            "user_id" => $request->user->id,
            "name" => $validated['name'],
            "file" => $path
        ]);

        return response([
            'file_path' => $path,
            'id' => $file->id
        ], Response::HTTP_CREATED);
    }


    public function upload_file(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'file' => 'required|string',
                'password' => "required|string"
            ]);
        } catch (Exception $e) {
            return response([
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        $image_64 = $validated['file']; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

      // find substring fro replace here eg: data:image/png;base64,

       $image = str_replace($replace, '', $image_64);

       $image = str_replace(' ', '+', $image);

       $imageName = Str::random(10).'.'.$extension;

       Storage::disk('public')->put($imageName, base64_decode($image));

        $path = $imageName;

        $file = File::create([
            "name" => $validated['name'],
            "file" => $path,
            "password" => $validated['password']
        ]);

        return response([
            'message' => 'success'
        ], Response::HTTP_CREATED);
    }
}



