<?php

use App\User;
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user', function() {
    return User::all();
}); 

Route::post('user', function(Request $request) {
    $user = User::create($request->all());
    return $user;
});

Route::put('user/{id}', function(Request $request, $id) {
    $user = User::find($id);
    $user->update($request->all());
    return $user;
});

Route::delete('user/{id}', function($id) {
    $user = User::find($id);
    $user->delete();
    return $user;
});