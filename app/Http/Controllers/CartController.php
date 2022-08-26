<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade;

class CartController extends Controller
{

    public function cartList()
    {
        $cartItems = CartFacade::getContent();
        return $cartItems;
        // return view('admin.transaction.index', compact('cartItems'));
    }

    public function cekCart() // Hanya untuk cek Data
    {
        $cartItems = CartFacade::getContent();
        $cek = count($cartItems);
        $data = '';

        $sorted = $cartItems->sortByDesc('attributes');
        // $sorted = $cartItems->sortByDesc(function ($product, $key) {
        //     return count($product->attributes->order);
        // });

        // foreach ($sorted as $item) {
        //     $data .= ' | ' . $item->attributes->order;
        // }
        dd($sorted);
    }

    public function cartTable()
    {
        $cartItems = CartFacade::getContent();
        $sorted = $cartItems->sortByDesc('attributes');
        $output = '';
        $no = 0;
        foreach ($sorted as $item) {
            $no++;

            $totalItem = $item['quantity'] * $item['price'];
            $output .= '
			<tr>
			<td>' . $no . '</td>
			<td>' . $item['name'] . '</td>
			<td style="text-align: right;">' . $item['quantity'] . '</td>
			<td style="text-align: right;">' . number_format($item['price']) . '</td>
            <td style="text-align: right;">' . number_format($totalItem) . '</td>
            <td><button class="btn btn-info text-white btnEditItem" title="Edit" id="' . $item['id'] . '"><i class="bi bi-card-list"></i></button> <button class="btn btn-danger text-white border-0 btnHapusItem" title="Hapus" id="' . $item['id'] . '"><i class="bi bi-trash-fill"></i></button></td>
            <td style="display:none;">' . $item['id'] . '</td>
			</tr>                                          
			';
        }
        return $output;
    }

    public function addToCart(Request $request)
    {
        $cartItems = CartFacade::getContent();
        $cek = count($cartItems);

        CartFacade::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'order' => $cek,
            )
        ]);

        // return CartFacade::getContent();
        return CartFacade::getTotal();
    }

    public function updateCart(Request $request)
    {
        CartFacade::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
                'price' =>  $request->price,
            ]
        );

        return CartFacade::getTotal();

        // Return something to report while success
    }

    public function removeCart(Request $request)
    {
        CartFacade::remove($request->id);

        // Return something to report while success
    }

    public function clearAllCart()
    {
        CartFacade::clear();
        // Return something to report while success
    }
}
