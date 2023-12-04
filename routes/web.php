<?php

use App\Factories\AnnotationFactory;
use App\Factories\MatterRelationFactory;
use App\Http\Controllers\MatterRelationController;
use App\Models\Annotation;
use App\Models\Law;
use App\Models\Matter;
use App\Models\MatterRelation;
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
    $law = Law::find('9ac4a955-316b-42b8-ae56-b18325ca0563');
    $annotation = Annotation::find('9ac4a955-0df2-438d-b21e-91420aeb64b7');


    dd($annotation->laws()->withPivot(['cursorIndex'])->get());
});

Route::get('/annotation-test', function () {
    $annotation = (new AnnotationFactory)->create(Matter::find('9ac49f50-61d9-4fdb-b1b9-28f2ef5ff970'), 'dit is een annotatie');
    $retrieved = Annotation::find($annotation->id);
    dd($retrieved->matter);
});

Route::get('/matter-relations-test', function () {
    $matterA = Matter::create(['name' => 'Matter A', 'color' => '#000000']);
    $matterB = Matter::create(['name' => 'Matter B', 'color' => '#ffffff']);
    $relation = (new MatterRelationFactory)->create($matterA, $matterB, 'requires 1', 'Description');
    $retrievedRelation = MatterRelation::find($relation->id);
    dd($retrievedRelation->matterA, $retrievedRelation->matterB);
});

