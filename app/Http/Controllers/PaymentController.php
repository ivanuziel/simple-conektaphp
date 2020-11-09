<?php

namespace App\Http\Controllers;

use App\Events\ProcessPurchase;
use App\Http\Controllers\PaymentController;
use App\Http\Requests\PaymentRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function charge(PaymentRequest $request)
	{
		$order = Product::where('sku', $request->order['id'])->firstOrFail();
		$customer = auth()->user();
		$purchase = event(new ProcessPurchase($order, (object)$request->payment, $customer));

		if (request()->ajax()) {
			return response()->json($purchase[0]);
		}
	}
}
