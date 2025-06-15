<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class GetByIdClientController extends Controller
{
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function getById(Request $request, int $id)
    {
        return $this->client->getById($id);
    }
}
