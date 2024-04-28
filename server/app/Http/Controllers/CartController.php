<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::where('user_id', auth()->user()->id)
            ->with(['customer', 'sparepart'])
            ->get();
        return response()->json([
            'message' => 'success get carts',
            'carts' => $carts,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sparepart_id' => 'required',
            'qty' => 'required'
        ]);

        $data = $validator->validated();
        $data['customer_id'] = auth()->user()->id;

        $cart = Cart::create($validator->validated());

        return response()->json([
            'message' => 'Success store cart',
            'cart' => $cart,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'sparepart_id' => 'required',
            'qty' => 'required'
        ]);

        $data = $validator->validated();
        $data['customer_id'] = auth()->user()->id;

        $cart->update($validator->validated());

        return response()->json([
            'message' => 'Success edit cart',
            'cart' => $cart,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
