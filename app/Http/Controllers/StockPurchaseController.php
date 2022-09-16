<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockPurchase;
use Illuminate\Http\Request;

class StockPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.stock_purchase');
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
        // 				total	
        $data = ([
            'id_merchant' => '1',
            'id_product' => $request->prod_id,
            'quantity' => $request->qty,
            'price' => $request->price,
            'total' => $request->total
        ]);

        $res = StockPurchase::create($data);

        $stock = Stock::select("id_stock", "stock")
            ->where("id_merchant", "1")
            ->where("id_product", "{$request->prod_id}")
            ->where("capital_price", "{$request->price}")
            ->get();

        // dd($stock);
        if (count($stock) <= 0) {
            Stock::create([
                'id_merchant' => '1',
                'id_product' => $request->prod_id,
                'stock' => $request->qty,
                'capital_price' => $request->price,
                'price' => $request->total
            ]);
        } else {
            // return 'sudah ada stock';
            // return $stock;
            $newstock = $request->qty + $stock[0]->stock;
            // return $newstock;
            Stock::where('id_stock', $stock[0]->id_stock)->update(['stock' =>  $newstock]);
        }

        return $stock;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockPurchase  $stockPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(StockPurchase $stockPurchase)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockPurchase  $stockPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(StockPurchase $stockPurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockPurchase  $stockPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockPurchase $stockPurchase)
    {
        // cek apakah harga masih sama
        $stock = Stock::select("id_stock", "stock")
            ->where("id_stock", $request->stockId)
            ->get();
        // dd($request);

        // return $stock;

        $oldPurchase = StockPurchase::select("quantity", "price", "id_product")
            ->where("id", $stockPurchase->id)
            ->get();

        $oldPurchPrice = $oldPurchase[0]->price;
        $oldPurchQty = $oldPurchase[0]->quantity;
        $oldStock = $stock[0]->stock;
        $newStock = ($oldStock - $oldPurchQty) + $request->qty;

        if ($oldPurchPrice == $request->price) {
            // return 'data price sama';
            Stock::where("id_stock", $request->stockId)
                ->update([
                    'stock' => $newStock,
                ]);
        } else {
            $newStock = $oldStock - $oldPurchQty;
            Stock::where("id_stock", $request->stockId)
                ->update([
                    'stock' => $newStock,
                ]);

            Stock::create([
                'id_merchant' => '1',
                'id_product' => $request->prod_id,
                'stock' => $request->qty,
                'capital_price' => $request->price,
                'price' => $request->total
            ]);
        }

        StockPurchase::where('id', $stockPurchase->id)->update([
            'id_merchant' => '1',
            'id_product' => $request->prod_id,
            'quantity' => $request->qty,
            'price' => $request->price,
            'total' => $request->total
        ]);

        return $stock;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockPurchase  $stockPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockPurchase $stockPurchase)
    {
        //
    }

    public function getProductDataByName(Request $request)
    {
        $data = Product::select("id_product", "price")
            ->where("product_name", "{$request->term}")
            ->get();

        return response()->json($data);
    }

    public function getStockPurchaseList()
    {
        $data = StockPurchase::select('*', 'stock_purchases.price AS purchase_price')
            ->join('products', 'stock_purchases.id_product', '=', 'products.id_product')
            ->orderByDesc('id')->get();
        return response()->json($data);
    }

    public function cekEditPurchase(Request $request)
    {
        // dd($request);
        $stock = Stock::select("id_stock", "stock")
            ->where("id_merchant", "1")
            ->where("id_product", "{$request->prod_id}")
            ->where("capital_price", "{$request->price}")
            ->where("stock", ">=", "{$request->qty}")
            ->get();
        return response()->json($stock);
    }
}
