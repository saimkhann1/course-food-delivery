<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

 
class RestaurantController extends Controller
{
    public function index(): Response
    {
        Gate::authorize('restaurant.viewAny');  

        return Inertia::render('Admin/Restaurants/Index', [
            'restaurants'=>Restaurant::with(['city','owner'])->get(),
        ]);
}
}