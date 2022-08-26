<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cartItems = CartFacade::getContent();
        $data = '';
        foreach ($cartItems as $item) {
            // dd($request);
            $totalItem = $item['quantity'] * $item['price'];
            $data = [
                'id_transaction' => '1',
                'id_product' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $totalItem
            ];

            TransactionDetail::create($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function autocomplete(Request $request)
    {
        $res = Product::select("product_name", "id_product")
            ->where("product_name", "LIKE", "%{$request->term}%")
            ->limit(5)
            ->get();

        return response()->json($res);
    }

    public function getProductIdbyName(Request $request)
    {
        $data = Product::select("id_product")
            ->where("product_name", "{$request->term}")
            ->get();

        return response()->json($data);
    }
}
