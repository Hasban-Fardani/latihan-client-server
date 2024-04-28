<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Sparepart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Transaction $transaction)
    {
        $transactionDetails = TransactionDetail::with(['sparepart'])->where('transaction_id', $transaction->id)->get();
        return response()->json([
            'message' => 'Success get all transaction details',
            'transactionDetails' => $transactionDetails
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Transaction $transaction)
    {
        $validator = Validator::make($request->all(), [
            'values' => 'required|array',
            'values.*.qty' => 'required|integer',
            'values.*.sparepart_id' => 'required|exists:spareparts,id',
            'values.*.cart_id' => 'integer', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 200);
        }

        $data = $validator->validated()['values'];
        $totals = 0;
        for ($i=0; $i < count($data); $i++) {
            $price = Sparepart::where('id', $data[$i]['sparepart_id'])->pluck('price')->first(); 
            $data[$i]['transaction_id'] = $transaction->id;
            $subtotal = $price * $data[$i]['qty'];
            $data[$i]['subtotal'] = $subtotal;
            $totals += $subtotal;
        }

        $transaction->details()->createMany($data);
        $transaction->total += $totals;
        $transaction->save();
        
        $carts_id = collect($data)->map(function ($d) {
            return $d['cart_id'];
        });

        Cart::whereIn('id', $carts_id)->delete();

        return response()->json([
            'message' => 'Success store transaction details',
            'transaction' => $transaction->load('details'),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionDetail $transactionDetail)
    {
        return response()->json([
            'message' => 'Success gey transaction detail',
            'transactionDetail' => $transactionDetail
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionDetail $transactionDetail)
    {
        $transactionDetail->delete();
        return response()->json([
            'message' => 'Success delete transaction detail'
        ], 200);
    }
}
