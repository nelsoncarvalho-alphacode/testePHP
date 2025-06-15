<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class GetAllProductController extends Controller
{
    private $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function getAll(Request $request)
    {
        return $this->product->getAll();
    }
}
