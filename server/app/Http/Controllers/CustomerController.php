<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Success get all customer',
            'customers' => User::where('role', 'user')->get()
        ], 200);
    }
}
