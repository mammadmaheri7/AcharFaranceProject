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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return view('welcome');
});

Route::get('email',function () {
    \Illuminate\Support\Facades\Mail::send('email.test',['name'=>'MMD'],function ($message){
        $message->to('mohamadmaheri@yahoo.com','AcharFarance Admin')
                ->subject('welcome to AcharFarance');
    });
})                                                                  ->middleware('verified');

Route::get('/test',function (){
    Schema::disableForeignKeyConstraints();
    Schema::drop('users');
});

Route::resource('/scopes','ScopeController');

Route::resource('/orders','OrderController')                        -> middleware('verified');
Route::post('orders/{id}/photos','OrderController@addPhoto')        -> middleware('verified');
Route::get('orders/{id}/addPhoto','OrderController@addPhotoPage')   -> middleware('verified');

Route::resource('/skills','SkillController');
Route::post('skills/{id}/photos','SkillController@addPhoto');
Route::get('skills/{id}/addPhoto','SkillController@addPhotoPage');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('/login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');



Route::get('/home', 'HomeController@index')->name('home');

Route::get('/friends','FriendController@index')                     ->middleware('auth');

Route::get('/chat','ChatController@index')                          ->middleware('auth')->name('chat.index');
Route::get('/chat/{id}','ChatController@show')                      ->middleware('pv')->name('chat.show');
Route::post('/chat/getChat/{id}','ChatController@getChat')          ->middleware('auth');
Route::post('/chat/sendChat','ChatController@sendChat')             ->middleware('auth');

Route::get('/dashboard',function (){

    $user = auth()->user();
    $skills = $user->skills;

    $orders = array();
    foreach ($skills as $skill)
    {
        $orders = array_merge($orders, $skill->orders()->get()->toArray());
    }
    return $orders;
})                                                                  -> middleware('verified');


