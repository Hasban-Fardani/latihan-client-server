<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sparepart;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function categoriesAnalytics(){
        $categories = Category::all()->unique();
        $counts = array();

        foreach ($categories as $category) {
            $count = Sparepart::where('category_id', $category->id)->count();
            array_push($counts, $count);
        }

        return response()->json([
            'labels' => array_values($categories->pluck('name')->toArray()) ,
            'datasets' => [
                [
                    'label' => 'Data transaksi',
                    'data' => $counts
                ]
            ]
        ], 200);
    }

    public function transactionAnalytics() {
        $transactions = Transaction::all();
        $dates = $transactions->pluck('date')->unique();
        $counts = '';

        foreach ($dates as $key => $date) {
            $count = $transactions->where('date', $date)->count();
            if ($key == array_key_last($dates->toArray())) {
                $counts = $counts . strval($count);
            } else {
                $counts = $counts . strval($count) . '|';
            }
        }

        return response()->json([
            'labels' => array_values($dates->toArray()) ,
            'datasets' => [
                [
                    'label' => 'Data transaksi',
                    'data' => explode('|', $counts)
                ]
            ]
        ], 200);
    }

    public function exportPDF(Request $request, Transaction $transaction){
        $transaction->load(['details', 'details.sparepart', 'customer', 'user']);
        $data = [
            [
                'quantity' => 1,
                'description' => '1 Year Subscription',
                'price' => '129.00'
            ]
        ];
        
        $pdf = Pdf::loadView('pdf.invoice_transaction', ['data' => $data, 'transaction' => $transaction]);
        if ($request->input('view')) {
            return $pdf->stream();
        }
        return $pdf->download();
    }
}
