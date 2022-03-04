<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File as SysFile;

class MyApp extends Controller
{





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
        $file = File::find($id)->first();
        $folderPath=public_path("\storage\\". $file->file);
        unlink($folderPath);
        $file->delete();
        return response([
            "message" => "success"
        ]);
    }

    public function upload_file(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:files,name',
                'file' => 'required|file',
            ]);
        } catch (Exception $e) {
            return response([
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        //Storage::disk('local')->put( $validated['name'], $request->file('file'));
        //$path = Storage::url( $validated['name']);
        $path = $request->file('file')->store('images', 'public');

        $file = File::create([
            "user_id" => $request->user->id,
            "name" => $validated['name'],
            "file" => $path
        ]);



        return response([
            'file_path' => $path,
        ], Response::HTTP_CREATED);
    }
}
