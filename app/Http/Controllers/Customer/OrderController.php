<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(): Response
    {
        Gate::authorize('order.viewAny');

        $orders = Order::with(['restaurant', 'items']) 
         ->where('customer_id', Auth::id())
            ->latest()
            ->get();

        return Inertia::render('Customer/Orders', [ 
            'orders' => $orders,
        ]);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $user = $request->user();
        $attributes = $request->validated();

        DB::transaction(function () use ($user, $attributes) {
            $order = $user->orders()->create([
                'restaurant_id' => $attributes['restaurant_id'],
                'total'         => $attributes['total'],
                'status'        => OrderStatus::PENDING,
            ]);

            $order->items()->createMany($attributes['items']);
        });

        session()->forget('cart');

        return redirect()->route('customer.orders.index')
            ->withStatus('Order placed successfully!');
    }
}