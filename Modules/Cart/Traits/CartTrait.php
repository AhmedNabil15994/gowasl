<?php

namespace Modules\Cart\Traits;

use Cart;
use Illuminate\Support\Str;
use Modules\Cart\Entities\DatabaseStorageModel;

trait CartTrait
{
    public $authUserGuard;

    public function getCart()
    {
        return Cart::session($this->userToken());
    }

    public function getCartContent()
    {
        return Cart::session($this->userToken())->getContent();
    }

    public function userToken()
    {
        if (request()->user_token){

            $cartKey = request()->user_token;

        }elseif (request()->user()){

            $cartKey = request()->user()->id;

        }
        else {
            if (is_null(get_cookie_value(config('core.config.constants.CART_KEY')))) {
                $cartKey = Str::random(30);
                set_cookie_value(config('core.config.constants.CART_KEY',''), $cartKey);
            } else {
                $cartKey = get_cookie_value(config('core.config.constants.CART_KEY'));
            }
        }

        return $cartKey;
    }

    public function addToCart($item, $type, $quantity = 1)
    {
        $inCart = $this->findItemById($item, $type);

        if (!is_null($inCart)) {
            $this->updateItemInCart($item, $type);
        }

        $this->addItemToCart($item, $type, $quantity);

        return true;
    }

    public function findItemById($item, $type)
    {
        return $this->getCartContent()->get($item['id'] . '-' . $type);
    }

    public function addItemToCart($item, $type, $quantity = 1)
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => $item['id'] . '-' . $type,
            'name' => $item['title'],
            'price' => $item['price'],
            'quantity' => $quantity ?? 1,
            'attributes' => [
                'item_id' => $item['id'],
                'type' => $type,
                'image' => url($item['main_image']),
                'product' => $item,
            ]
        ]);

        return true;
    }

    public function updateItemInCart($item, $type)
    {
        $cart = $this->getCart();
        $cart->update($item['id'] . '-' . $type, [
            'quantity' => [
                'relative' => false,
                'value' => 0,
            ]
        ]);
        return true;
    }

    public function removeItem($id, $type)
    {
        $cart = $this->getCart();
        return $cart->remove($id . '-' . $type);
    }

    public function clearCart()
    {
        $cart = $this->getCart();
        $cart->clear();
        $cart->clearCartConditions();
        return true;
    }

    public function cartTotal()
    {
        $cart = $this->getCart();
        return $cart->getTotal();
    }

    public function updateCartKey($userToken, $newUserId)
    {
        DatabaseStorageModel::where('id', $newUserId . '_cart_conditions')->delete();
        DatabaseStorageModel::where('id', $newUserId . '_cart_items')->delete();
        DatabaseStorageModel::where('id', $userToken . '_cart_conditions')->update(['id' => $newUserId . '_cart_conditions']);
        DatabaseStorageModel::where('id', $userToken . '_cart_items')->update(['id' => $newUserId . '_cart_items']);
        return true;
    }
}
