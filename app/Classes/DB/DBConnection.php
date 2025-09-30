<?php

namespace DB;

use PDO;
use PDOException;

class DBConnection
{   

    // Cria as variáveis de conexão
    private $host = HOST;
    private $db_name = DB_NAME;
    private $username = USERNAME;
    private $password = PASSWORD;
    private $conn;

    // Cria o método de conexão com PDO   

    public function connect()
    {

        // Declara o método como nulo pra evitar problemas com valores antigos
        $this->conn = null;

        try {

            // Cria nova instância de conexão
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error' . $e->getMessage();
        }

        return $this->conn;
    }
}