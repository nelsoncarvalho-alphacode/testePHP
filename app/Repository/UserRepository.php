<?php

// Repository responsável por operações de banco de dados para usuários
namespace Repository;

use DB\DBConnection;

class UserRepository
{
    private $conn;

    // Inicializa conexão com banco de dados
    public function __construct()
    {
        $this->conn = (new DBConnection())->connect();
    }

    // Lista todos os usuários
    public function list()
    {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Busca usuário por ID
    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Cria novo usuário com validação de email único
    public function create(array $data)
    {
        try {
            // Verifica se já existe usuário com o mesmo e-mail
            $existing = $this->findByEmail($data['email']);
            if ($existing) {
                return ['error' => 'E-mail já cadastrado'];
            }
            
            // Prepara dados para inserção
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $isAdmin = isset($data['is_admin']) ? (int)$data['is_admin'] : 0;
            $cpf = $data['cpf'] ?? null;
            $endereco = $data['endereco'] ?? null;
            
            $stmt = $this->conn->prepare("INSERT INTO users (name, email, cpf, endereco, password, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$data['name'], $data['email'], $cpf, $endereco, $hashedPassword, $isAdmin]);
            return $this->conn->lastInsertId();
        } catch (\PDOException $e) {
            return false;
        }
    }

    // Atualiza dados de usuário com validação de email único
    public function update($id, array $data)
    {
        $fields = [];
        $values = [];
        
        // Constrói query dinâmica baseada nos campos fornecidos
        if (isset($data['name']) && !empty($data['name'])) {
            $fields[] = "name = ?";
            $values[] = $data['name'];
        }
        
        if (isset($data['email']) && !empty($data['email'])) {
            // Verifica se já existe outro usuário com o mesmo e-mail
            $existing = $this->findByEmail($data['email']);
            if ($existing && $existing['id'] != $id) {
                return ['error' => 'E-mail já está sendo usado por outro usuário'];
            }
            $fields[] = "email = ?";
            $values[] = $data['email'];
        }
        
        if (isset($data['cpf'])) {
            $fields[] = "cpf = ?";
            $values[] = $data['cpf'];
        }
        
        if (isset($data['endereco'])) {
            $fields[] = "endereco = ?";
            $values[] = $data['endereco'];
        }
        
        if (isset($data['password']) && !empty($data['password'])) {
            $fields[] = "password = ?";
            $values[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $values[] = $id;
        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($values);
    }

    // Remove usuário do banco
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Busca usuário por email (usado para autenticação e validação)
    public function findByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
