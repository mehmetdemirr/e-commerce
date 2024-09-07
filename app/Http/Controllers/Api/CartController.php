<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Interfaces\CardRepositoryInterface;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartRepository;

    public function __construct(CardRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $cart = $this->cartRepository->getCartByUser($userId);
        
        return response()->json([
            'success'=> true,
            'data' => $cart,
            'errors' => null,
            'message' => null,
            ], 200
        );
    }

    public function store(StoreCartItemRequest $request)
    {
        $userId = $request->user()->id;
        $cart = $this->cartRepository->getCartByUser($userId);

        if (!$cart) {
            $cart = $this->cartRepository->createCart($userId);
        }

        $cartItem = $this->cartRepository->addItemToCart($cart->id, $request->product_id, $request->quantity);


        if(!$cartItem){
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => "Ürün stokta bu kadar yok",
                'message' => null,
                ], 400
            );
        }
        else
        {
            return response()->json([
                'success'=> true,
                'data' => $cartItem,
                'errors' => null,
                'message' => null,
                ], 200
            );
        }
    }

    public function update(UpdateCartItemRequest $request, $itemId)
    {

        $cartItem = $this->cartRepository->updateCartItemQuantity($itemId, $request->quantity);

        if ($cartItem) {
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => null,
                'message' => "Ürün adedi güncellendi",
                ], 200
            );
        } else {
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => "Ürün bulunamadı veya güncellenemedi(ürün stoğundan fazla girilmiş olabilir)",
                'message' => null,
                ], 400
            );
        }
    }

    public function destroy($itemId)
    {
        $response = $this->cartRepository->removeItemFromCart($itemId);
        if ($response) 
        {
            return response()->json([
                'success'=> true,
                'data' => null,
                'errors' => null,
                'message' => "Silindi",
                ], 200
            );
        }
        else{
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => "Böyle bir item bulunamadı",
                'message' => null,
                ], 400
            );
        }
    }
}
