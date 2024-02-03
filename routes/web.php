<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryContoller;
use Illuminate\Http\Request; // Add this line for the Request class

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.login');
});

// Route::get('/',[AdminLoginController::class,'index'])->name('admin.login');//

Route::group(['prefix' => 'admin'], function(){


    Route::group(['middleware' => 'admin.guest'],function(){
     

        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authentictae',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
       

    });

    Route::group(['middleware' => 'admin.auth'],function(){
        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

            //CATEGORY rOUTE
        Route::get('/categories/create',[CategoryContoller::class,'create'])->name('admin.category.create');
        Route::post('/categories',[CategoryContoller::class,'store'])->name('categories.store');

        Route::get('/categories/create',[CategoryContoller::class,'create'])->name('admin.category.create');


        Route::get('/getSlug',function(Request $request){
            $slug = '';
            if (!empty($request->title)){

                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');

    });

    
});