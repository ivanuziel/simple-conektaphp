<?php

use App\Http\Controllers\PaymentController;
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
})->name('home');

Route::post('payments/charge', [PaymentController::class, 'charge'])->name('payment.charge');

Route::get('demo/login', function(){
	\App\Models\User::firstOrCreate(['email' => 'user@gmail.com'], [
		'name' => 'Demo User',
		'password' => bcrypt('123')
	]);
	Auth::attempt(['email' => 'user@gmail.com', 'password' => '123'], true);

	\App\Models\Product::firstOrCreate(['sku' => 'MXN371599664762'], [
		'name' => 'Producto de prueba',
		'price' => 55.5
	]);

	return redirect()->route('home');

})->name('demo.login');

