<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Transaction::get();

        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Transaction::rules('insert'));
        Transaction::customValidation($validator);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 400);
        }

        try {
            $transaction = Transaction::create($request->all());

            $product = Product::find($transaction->product_id);
            if ($transaction->transaction_type === 'in') {
                $product->updateStock($transaction->quantity, 'in');
            } elseif ($transaction->transaction_type === 'out') {
                if ($product->stock_quantity < $transaction->quantity) {
                    return response()->json(['message' => 'Stok tidak cukup untuk transaksi keluar.'], 400);
                }
                $product->updateStock($transaction->quantity, 'out');
            }

            return response()->json(['message' => 'Data transaksi berhasil disimpan', 'data' => $transaction], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Transaction::find($id);

            return response()->json(['data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = Transaction::find($id);

            return response()->json(['data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), Transaction::rules('update'));
        Transaction::customValidation($validator);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 400);
        }

        try {
            $transaction = Transaction::find($id);
            if (!$transaction) {
                return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
            }

            $previousQuantity = $transaction->quantity;
            $previousTransactionType = $transaction->transaction_type;

            $transaction->update($request->all());

            $product = Product::find($transaction->product_id);

            $quantityDifference = $transaction->quantity - $previousQuantity;

            if ($transaction->transaction_type === 'in') {
                if ($previousTransactionType === 'out') {
                    $product->updateStock($previousQuantity, 'in');
                }
                $product->updateStock($quantityDifference, 'in');
            } elseif ($transaction->transaction_type === 'out') {
                if ($previousTransactionType === 'in') {
                    $product->updateStock($previousQuantity, 'out');
                }
                if ($product->stock_quantity < $transaction->quantity) {
                    return response()->json(['message' => 'Stok tidak cukup untuk transaksi keluar.'], 400);
                }
                $product->updateStock($quantityDifference, 'out');
            }

            return response()->json(['message' => 'Data transaksi berhasil diupdate', 'data' => $transaction], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Transaction::find($id);
            $data->delete();

            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
