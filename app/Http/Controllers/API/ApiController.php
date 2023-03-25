<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
   public function categoryList(){
        $category = Category::get();

        $response =[
            'status' => 200,
            'message' => "success",
            'data' => $category
        ];
        return Response::json($response);
    }

    public function createCategory(Request $request){
        $data = [
            'category_name' => $request->categoryName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        Category::create($data);

        return Response::json([
            'stauts' => 200,
            'message' => 'success',
        ]);
    }

    // public function categoryDetails(Request $request){
    //     $id = $request->id;
    //     $data = Category::where('category_id',$id)->first();

    //     if(!empty($data)){
    //         return Response::json([
    //             'status' => 200,
    //             'message' => 'success',
    //             'data' => $data
    //         ]);
    //     }

    //     return Response::json([
    //         'status' => 200,
    //         'message' => 'fail',
    //         'data' => $data
    //     ]);


    // }

    public function categoryDetails($id){
        $data = Category::where('category_id',$id)->first();

        if(!empty($data)){
            return Response::json([
                'status' => 200,
                'message' => 'success',
                'data' => $data
            ]);
        }

        return Response::json([
            'status' => 200,
            'message' => 'fail',
            'data' => $data
        ]);


    }

    public function categoryDelete($id){
        $data = Category::where('category_id',$id)->first();

        if(empty($data)){
            return Response::json([
                'status' => 200,
                'message' => 'There is no category data with this id'
            ]);
        }

        Category::where('category_id',$id)->delete();

        return Response::json([
            'status' => 200,
            'message' => 'success'
        ]);

    }

    public function categoryUpdate(Request $request){
        $updateData = [
            'category_id' => $request->id,
            'category_name' => $request->categoryName,
            'created_at' => Carbon::now()
        ];

        $check = Category::where('category_id',$request->id)->first();

        if(!empty($check)){
            Category::where('category_id',$request->id)->update($updateData);
            return Response::json([
                'status' => 200,
                'message' => 'success'
            ]);
        }

        return Response::json([
            'status' => 200,
            'message' => 'There is no data in that id'
        ]);
    }
}
