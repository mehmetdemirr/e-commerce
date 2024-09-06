<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartItemRequest;
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

    public function index(StoreCartItemRequest $request)
    {
        $userId = $request->user()->id;
        $cart = $this->cartRepository->getCartByUser($userId);
        
        return response()->json(['success' => true, 'data' => $cart]);
    }

    public function store(StoreCartItemRequest $request)
    {
        $userId = $request->user()->id;
        $cart = $this->cartRepository->getCartByUser($userId);

        if (!$cart) {
            $cart = $this->cartRepository->createCart($userId);
        }

        $cartItem = $this->cartRepository->addItemToCart($cart->id, $request->product_id, $request->quantity);

        return response()->json(['success' => true, 'data' => $cartItem]);
    }

    public function destroy($itemId)
    {
        $this->cartRepository->removeItemFromCart($itemId);
        return response()->json(['success' => true, 'message' => 'Item removed from cart']);
    }
}
