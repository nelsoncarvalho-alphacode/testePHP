<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class GetByIdProductController extends Controller
{
    private $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function getById(Request $request, int $id)
    {
        return $this->product->getById($id);
    }
}
