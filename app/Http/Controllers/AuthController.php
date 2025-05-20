<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Registration;
use App\Models\Category;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                "name" => "required|string|max:255",
                "email" => "required|string|max:255|unique:registration,email",
                "password" => "required|string|min:4",
                "role" => "required|string",
            ]);

            $registration = Registration::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => $request->role
            ]);


            $image = [
                'https://static.vecteezy.com/system/resources/thumbnails/027/951/137/small_2x/stylish-spectacles-guy-3d-avatar-character-illustrations-png.png',
                'https://i.pinimg.com/474x/0a/a8/58/0aa8581c2cb0aa948d63ce3ddad90c81.jpg',
                'https://cdn-icons-png.flaticon.com/512/168/168732.png',
                'https://www.w3schools.com/w3images/avatar2.png',
                'https://st.depositphotos.com/46542440/55685/i/450/depositphotos_556850840-stock-illustration-square-face-character-stiff-art.jpg',
                'https://static.vecteezy.com/system/resources/previews/024/183/502/original/male-avatar-portrait-of-a-young-man-with-a-beard-illustration-of-male-character-in-modern-color-style-vector.jpg'
            ];




            $randomImage = $image[array_rand($image)];
            Profile::create([
                "profilepic" => $randomImage,
                'registration_id' => $registration->id,
                // "category_id"=> $registration->id,

            ]);

            // Category::create([
            //     // "role"=>category->category,
            //      'category_id' => $registration->id,
            // ]);



            DB::commit();

            return response()->json([
                "message" => "registration successfully",
                "data" => $registration,
                "status" => "true"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "error" => $e->getMessage(),
                "status" => "false"
            ], 500);
        }

    }

    public function login(Request $request)
    {
        try {
            DB::beginTransaction();
            // $user=auth()-user();
            $credentialS = $request->only("email", "password");

            if (!$token = Auth::attempt($credentialS)) {
                return response()->json(['error' => 'Invalid Credentials']);
            }
            DB::commit();
            return response()->json([
                "message" => "login successfully",
                "data" => $token,
                "status" => "true"
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "error" => $e->getMessage(),
                "status" => "false"
            ], 500);
        }

    }

    public function getprofile(Request $request)
    {
        $userData = auth()->user();
        $profile = $userData->profile;
        $profileData = [
            "name" => $userData->name,
            "email" => $userData->email,
            "profile" => $profile
        ];
        return response()->json([
            "message" => "fetch the profile data",
            "data" => $profileData,
            "status" => "true"
        ], 200);


    }

    public function updateprofile(Request $request)
    {
        try {
            DB::beginTransaction();
            $validateData = $request->validate([
                "dob" => "required|date",
                "gender" => "required|string|max:255",
                // "profilepic" => "required|string|max:255",
                "phone" => "required|string",
                "category_id" => "array",
                "category_id.*" => "exists:category,id"
            ]);
            if (!$validateData) {
                return response()->json([
                    "message" => "invalid data type ",
                    "status" => "false"

                ]);
            }

            $userData = auth()->user();
            $profile = $userData->profile;

            if ($request->has('category_id')) {
                $profile->preferredCategories()->sync($request->category_id);
            }
           
            $updateData = $profile->updateorcreate(["id"=>$profile->id],[
                "dob" => $request->dob,
                "phone" => $request->phone,
                "gender" => $request->gender,
                "email" => $userData->email,
                "profilepic" => $profile->profilepic,
                // "category_id"=>$profiles['category_id'],
            ]);
            $updateData->save();
        
            DB::commit();
            return response()->json([
                "message" => "update data successfully",
                "data" => $updateData,
                "status" => "true"
            ], 200);


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "error" => $e->getMessage(),
                "status" => "false"
            ], 500);
        }

    }

    
}


