<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class GetAllClientController extends Controller
{
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function getAll(Request $request)
    {
        return $this->client->getAll();
    }
}
