<?php

use App\Models\Annotation;
use App\Models\Law;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $law = Law::find('9ac42c4e-78ff-4a11-b532-a3ed3ef35cfd');
    $annotation = Annotation::find('9ac42c4e-49a2-4f5c-a272-306c2389f713');


    dd($annotation->law()->withPivot(['cursor_index'])->get());
});
