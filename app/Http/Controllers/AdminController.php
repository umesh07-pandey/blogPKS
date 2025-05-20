<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function insert(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validate([
                "category" => "required|string|max:255",
            ]);

            $categoryData = Category::create([
                "category" => $request->category,
            ]);
            DB::commit();
            return response()->json([
                "message" => "the category created suceddfully",
                "status" => "true",
                "data" => $categoryData,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }
    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $validateData = $request->validate([
                "category" => "required|string|max:255",
            ]);
            $categoryData = Category::find($id);
            if (!$categoryData) {
                return response()->json([
                    "message" => "category not found",
                    "status" => "false",
                ], 404);
            }
            $categoryData->category = $request->category;
            $categoryData->save();
            DB::commit();

            return response()->json([
                "message" => "category update successfully",
                "status" => "true",
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error", $e->getMessage()], 500);
        }



    }
    public function delete(Request $request, $id)
    {
        $categoryData = Category::find($id);
        if (!$categoryData) {
            return response()->json([
                "message" => "category not found",
                "status" => "false",
            ], 404);
        }
        $categoryData->delete();

        return response()->json([
            "message" => "category delete successfully",
            "status" => "true",
        ], 200);



    }
    public function fetchall(Request $request)
    {

        try {
            $categories = Category::all();

            return response()->json([
                "message" => "fetch all category data",
                "data" => $categories,
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
