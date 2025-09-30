<?php

namespace Repository;

use DB\DBConnection;

class UserRepository {
    private $conn;

    public function __construct()
    {
        $this->conn = (new DBConnection())->connect();
    }

    public function show() {

    }

    public function create() {

    }

    public function update() {

    }

    public function delete() {
        
    }
}