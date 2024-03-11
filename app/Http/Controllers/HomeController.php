<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Categorie;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request, Client $clientModel, Categorie $categorieModel, Product $productModel)
    {
        $perPage = $request->input('per_page', 20);

        $topClientsByOrders = $clientModel->withCount('orders')
            ->orderByDesc('orders_count')
            ->take(3)
            ->get();

        $topClientsBySpending = $clientModel->withSum('orders', 'total')
            ->orderByDesc('orders_sum_total')
            ->take(3)
            ->get();

        $categories = Categorie::whereHas('products', function ($query) {
                $query->where('status', 1)
                      ->whereNull('deleted_at');
            })
            ->orderBy('name')
            ->get();

        if ($categories->isEmpty()) {
            $products = collect(); // Lista de produtos vazia
        } else {
            $products = $productModel->whereNull('deleted_at')
                ->where('status', 1)
                ->where('categorie_id', $categories->first()->id)
                ->orderBy('name')
                ->paginate($perPage);
        }

        return view('home', compact('perPage', 'topClientsByOrders', 'topClientsBySpending', 'categories', 'products'));
    }
}
