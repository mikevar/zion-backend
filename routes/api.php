<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Models\Message;
use App\Events\MessageEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/messages', function (Request $request) {
    return Message::all();
});

Route::post('/messages', function (Request $request) {
    $message = new Message;
    $message->username = $request->input('username');
    $message->message = $request->input('message');
    $message->save();

    event(new MessageEvent($message->username, $message->message));

    return $request->all();
});
