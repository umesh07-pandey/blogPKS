<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{

    public function create_post(Request $request)
    {

        try {
            DB::beginTransaction();
            $userData = auth()->user();

            $validateData = $request->validate([
                "title" => "required|string|max:255",
                "discription" => "required|string|max:255",
            ]);
            if (!$validateData) {
                return response()->json([
                    "message" => "invalid data",
                    "status" => "false"
                ], 500);
            }
           $postData= Post::create([
                "title" => $request->title,
                "discription" => $request->discription,
                "registration_id"=>$userData->id
            ]);
            $data=[
                $userData->id,
                $postData->title,
                $postData->discriptio,
                $postData->registration_id,
                $userData->post()
            ];
            DB::commit();

            return response()->json([
                "message" => "post created successfully",
                "data"=>$data,
                "status" => "true"
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "error" => $e->getMessage(),
                "status" => "false"
            ], 500);
        }


    }
}
