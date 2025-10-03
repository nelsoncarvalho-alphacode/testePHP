<?php

// Classe responsável por gerenciar conexão com banco de dados MySQL
namespace DB;

use PDO;
use PDOException;

class DBConnection
{
    // Variáveis de configuração da conexão
    private $host = HOST;
    private $db_name = DB_NAME;
    private $username = USERNAME;
    private $password = PASSWORD;
    private $conn;

    // Estabelece conexão PDO com banco MySQL
    public function connect()
    {
        // Inicializa conexão como nula
        $this->conn = null;

        try {
            // Cria nova instância PDO com configurações
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error' . $e->getMessage();
        }

        return $this->conn;
    }
}
