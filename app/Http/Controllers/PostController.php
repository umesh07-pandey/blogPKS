<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PostController extends Controller
{

    public function create_post(Request $request)
    {

        try {
            DB::beginTransaction();
            $userData = auth()->user();
            // $userCategoryData=$userData->category;
            // Log::info("category object",["category data:",$userCategoryData]);

            $request->validate([
                "title" => "required|string|max:255",
                "description" => "required|string|max:255",
                "category_id" => "required|exists:category,id"

            ]);
            
           $postData= Post::create([
                "title" => $request->title,
                "description" => $request->description,
                "registration_id"=>$userData->id,
                "category_id"=>$request->category_id,
            ]);
            $data=[
                $userData->id,
                $postData
            //     $postData->title,
            //     $postData->description,
            //    $postData->registration_id,
                
                // $userData->post()
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
    public function update_post(Request $request){
        try {
            DB::beginTransaction();
            $userData=auth()->user();
            $postid = $request->query('id');
            
            $postdata = Post::find($postid );
            if(!$postdata){
                return response()->json([
                    "message"=>"the post is not found",
                    "status"=>"false"
                ],404);
            }

            // Log::info("post data :",["post data"=>$postData]);
            $validateData = $request->validate([
                "title"=>"required|string|max:255",
                "description"=>"required|string|max:255",
                "category_id" => "required|exists:category,id"

            ]);
            if(!$validateData){
                return response()->json([
                    "message"=>"data is not valid",
                    "status"=>"false"
                ]);
            }
            $updateData=$postdata->update([
                "title"=> $request->title,
                "description"=> $request->description,
                "category_id"=>$request->category_id
            ]);
            DB::commit();

            return response()->json([
                "message"=>"post data update succesfully",
                "data"=>$postdata,
                "status"=>"true"
            ],200);

        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                "message"=>$e->getMessage(),
                "status"=>"false"
            ],500);
        }
    }

    public function delete_post(Request $request){
        try{

            DB::beginTransaction();
            $post_id=$request->query("id"); 
            $postdata=Post::find($post_id);
            if(!$postdata){
                return response()->json([
                    "message"=>"the post is not found",
                    "status"=>"false"
                ],404);
            }
            $postdata->delete();
            DB::commit();
            return response()->json([
                "message"=>"post delete successfully",
                "status"=>"true",
            ],200);

        }catch(\Exception $e){
           DB::rollBack();
           return response()->json([
            "error"=>$e->getMessage(),
            "status"=>"false"
           ],500);
        }
    }

    public function get_post(Request $request){
        try{
            DB::beginTransaction(); 
            $data=auth()->user();

            $postdata=$data->post;
           
            foreach($postdata as $post){
                 $post->comments;
            }

            $post_Data=[
                "post"=>$postdata,
            ];
            DB::commit();
            return response()->json($post_Data);

        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                "error"=> $e->getMessage(),
                "status"=>"false"
            ],500);
        }
    }


}
