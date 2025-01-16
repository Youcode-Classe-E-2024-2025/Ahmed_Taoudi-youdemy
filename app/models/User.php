<?php

require_once "app/enums/Role.php";
require_once "app/enums/UserStatus.php";

class User
{
    protected $conn;
    protected $table = 'users';

    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected UserStatus $status;
    protected Role $role;
    protected $created_at;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }



    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    // Setters
    public function setId($id): void
    {
        $this->id = $id;
    }
    public function setName($name): void
    {
        $this->name = $name;
    }
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setStatus(UserStatus $status): void
    {
        $this->status = $status;
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }


    //create
    public function create(): bool
    {
        $query = "INSERT INTO " . $this->table . " 
                  (name, email, password, status, role, created_at)
                  VALUES 
                  (:name, :email, :password, :status, :role, NOW())";

        $params = [
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password,
            ':status' => $this->status->value,
            ':role' => $this->role->value
        ];

        try {
            $this->conn->query($query, $params);
            return true;
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    public function read($id = null, bool $includeArchived = false): array
    {
        $query = "SELECT u.* FROM " . $this->table . " u";
        $params = [];

        if (!$includeArchived) {
            $query .= " WHERE u.status != :archived";
            $params[':archived'] = UserStatus::ARCHIVED->value;
        }

        if ($id) {
            $query .= $includeArchived ? " AND u.id = :id" : " WHERE u.id = :id";
            $params[':id'] = $id;
        }

        try {
            $result = $this->conn->query($query, $params);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error reading user: " . $e->getMessage());
            return [];
        }
    }
    public function update(): bool
    {
        $query = "UPDATE " . $this->table . "
                  SET name = :name,
                      email = :email,
                      status = :status,
                      role = :role
                  WHERE id = :id AND status != :archived";

        $params = [
            ':name' => $this->name,
            ':email' => $this->email,
            ':status' => $this->status->value,
            ':role' => $this->role->value,
            ':id' => $this->id,
            ':archived' => UserStatus::ARCHIVED->value
        ];

        try {
            $this->conn->query($query, $params);
            return true;
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    // SOFT DELETE 
    public function delete(): bool
    {
        $query = "UPDATE " . $this->table . "
                  SET status = :archived
                  WHERE id = :id";

        $params = [
            ':archived' => UserStatus::ARCHIVED->value,
            ':id' => $this->id
        ];

        try {
            $this->conn->query($query, $params);
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }
    // Restore (set status to active) 
    public function restore(): bool
    {
        $query = "UPDATE " . $this->table . "
                  SET status = :active
                  WHERE id = :id";

        $params = [
            ':active' => UserStatus::ACTIVE->value,
            ':id' => $this->id
        ];

        try {
            $this->conn->query($query, $params);
            return true;
        } catch (PDOException $e) {
            error_log("Error restoring user: " . $e->getMessage());
            return false;
        }
    }

    }
