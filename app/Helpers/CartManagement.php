<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    // Add item to cart
    static public function addItemToCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity']++;
            $cart_items[$existing_item]['total_amount'] =
                $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);

            if ($product) {
                $cart_items[] = [
                    'product_id'   => $product_id,
                    'name'         => $product->name,
                    'image'        => $product->images[0] ?? null,
                    'quantity'     => 1,
                    'unit_amount'  => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

      // Add item to cart with qty
    public static function addItemToCartWithQty($product_id, $qty = 1)
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity'] = $qty;
            $cart_items[$existing_item]['total_amount'] =
                $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);

            if ($product) {
                $cart_items[] = [
                    'product_id'   => $product_id,
                    'name'         => $product->name,
                    'image'        => $product->images[0] ?? null,
                    'quantity'     => $qty,
                    'unit_amount'  => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    // Remove item from cart
    public static function removeCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
            }
        }

        $cart_items = array_values($cart_items);
        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    // Add items to cookie
    public static function addCartItemsToCookie($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    // Clear all cart items
    public static function clearCartItems()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // Get cart items from cookie
    public static function getCartItemsFromCookie()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        return $cart_items ?: [];
    }

    // Increment quantity
    public static function incrementQuantityToCartItems($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] =
                    $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Decrement quantity
    public static function decrementQuantityToCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                if ($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] =
                        $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Calculate grand total
    public static function calculateGrandTotal($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
