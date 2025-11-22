<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    // 👇 YE FUNCTION MISSING THA, ISAY ADD KAREIN
    public function index(): Response
    {
        return Inertia::render('Home', [
            'restaurants' => Restaurant::get(),
        ]);
    }
}