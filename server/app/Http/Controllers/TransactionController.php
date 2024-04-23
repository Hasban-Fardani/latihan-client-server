<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Success get all transactions',
            'transactions' => Transaction::with(['user', 'customer', 'details'])->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'customer_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => 'Invalid fields'
            ], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->user()->id;
        $data['date'] = now();

        $transaction = Transaction::create($data);

        return response()->json([
            'message' => 'Success store new transaction',
            'transaction' => $transaction
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return response()->json([
            'message' => 'Success get transaction',
            'transaction' => $transaction->load('details')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        
        return response()->json([
            'message' => 'Success delete transaction'
        ], 200);
    }
}
