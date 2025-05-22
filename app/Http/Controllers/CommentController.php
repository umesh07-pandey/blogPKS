<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Comment;

class CommentController extends Controller
{
    public function createcomment(Request $request){
        try{
            DB::beginTransaction(); 
            $userData=auth()->user();
            $postdata=$userData->post;
            Log::info("post data object",["pot data:"=>$postdata]);


           $validateData= $request->validate([
                "comment"=>"required|string|max:255",
                "post_id"=>"required|exists:post,id",
                // "registration_id"=>"required|exists:registration,id",
            ]);

            if (!$validateData) {
                return response()->json([
                    "message" => "invalid data type ",
                    "status" => "false"

                ]);
            }
            $commentData=Comment::create([
                "comment"=>$request->comment,
                "post_id"  =>$request->post_id,
                "registration_id"=>$userData->id

            ]);
            $commentData->save();
            $data=[
                $commentData,
                // $postdata,
                $userData->id

            ];
            if(!$data){
                return response()->json("error");

            }
            DB::commit();
            Log::info("data",["data"=>$data]);
            return response()->json([
                "message"=>"comment successfully",
                "data"=>$data,
                "status"=>"false"
            ],201);



        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(["error"=>$e->getMessage(),"status"=>"false"]);

        }
    }
    public function deletecomment(Request $request){
        try{
            DB::beginTransaction();
            $data=$request->query("id");
            if(!$data){
                return response()->json(["message"=>"comment is not found","status"=>"false"],404);

            }
            $commentData=Comment::find($data);

           $commentData->delete();

           DB::commit();
            return response()->json(["message"=>"comment delete successfully","status"=>"false"]);

        }
        catch(\Exception $e){
            return response()->json(["error"=>$e->getMessage()]);
        }
    }
}
