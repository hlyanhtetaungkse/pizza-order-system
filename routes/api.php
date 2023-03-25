<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::post('register','AuthController@register');
Route::post('login','AuthController@login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'category','namespace'=>'API','middleware'=>'auth:sanctum'],function(){
   Route::get('list','ApiController@categoryList'); //list
   Route::post('create','ApiController@createCategory'); //create
// Route::post('details','ApiController@categoryDetails');// details
   Route::get('details/{id}','ApiController@categoryDetails');//details
   Route::get('delete/{id}','ApiController@categoryDelete');//delete
   Route::post('update','ApiController@categoryUpdate');//update

   Route::get('logout','AuthController@logout');//logout
});

Route::group(['middleware'=>'auth:sanctum'],function(){

    Route::get('logout','AuthController@logout');//logout
 });
