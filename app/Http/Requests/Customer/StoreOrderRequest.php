<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('order.create');
    }

    public function rules(): array
    {
        return [
            'restaurant_id'         => ['required', 'exists:restaurants,id'],
            'items'                 => ['required', 'array', 'min:1'],
            'items.*.id'            => ['required', 'exists:products,id'],
            'items.*.name'          => ['required', 'string'],
            'items.*.price'         => ['required', 'numeric'],
            'items.*.restaurant_id' => ['required', 'exists:restaurants,id', 'in:' . $this->restaurant_id],
            'total'                 => ['required', 'numeric', 'gt:0','min:1'],
        ];
    }

  protected function prepareForValidation(): void
    {
        $cart = session('cart');

        if (!$cart) {
            throw ValidationException::withMessages([
                'cart' => 'Your cart is empty. Please add items to order.',
            ]);
        }

        $this->merge([
            'restaurant_id' => $cart['restaurant_id'],
            'items'         => $cart['items'],
            'total'         => $cart['total'],
        ]);
    }
}
