<?php

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
use App\Http\Controllers\Auth\SocialAccountController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('email',function () {
    \Illuminate\Support\Facades\Mail::send('email.test',['name'=>'MMD'],function ($message){
        $message->to('mohamadmaheri@yahoo.com','AcharFarance Admin')
                ->subject('welcome to AcharFarance');
    });
})->middleware('verified');

Route::resource('/scopes','ScopeController');

Route::resource('/orders','OrderController');
Route::post('orders/{id}/photos','OrderController@addPhoto');
Route::get('orders/{id}/addPhoto','OrderController@addPhotoPage');

Route::resource('/skills','SkillController');
Route::post('skills/{id}/photos','SkillController@addPhoto');
Route::get('skills/{id}/addPhoto','SkillController@addPhotoPage');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('/login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard',function (){

    $user = auth()->user();
    $skills = $user->skills;

    $orders = array();
    foreach ($skills as $skill)
    {
        $orders = array_merge($orders, $skill->orders()->get()->toArray());
    }
    return $orders;

});
