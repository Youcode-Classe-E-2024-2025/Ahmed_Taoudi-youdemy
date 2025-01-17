<?php

// require_once "app/enums/Role.php";
// require_once "app/enums/UserStatus.php";

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
    public function setCreatedAt($date){
        $this->created_at = date('d M Y', strtotime($date));
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
        $users = [];
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
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            if($data){
                foreach($data as $item){
                    $users[]= $this->createObject($item);
                }
            }
            return $users;

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


    public function login(string $email, string $password)
    {
        $query = "SELECT u.* FROM " . $this->table . " u 
                  WHERE u.email = :email AND u.status != :archived";

        $params = [
            ':email' => $email,
            ':archived' => UserStatus::ARCHIVED->value
        ];

        try {
            $result = $this->conn->query($query, $params);
            $user = $result->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error logging in: " . $e->getMessage());
            return false;
        }
    }


    public function countUsers()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $result = $this->conn->query($query, []);
        return $result->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function getById($id)
    {
        $query = "SELECT  *  FROM $this->table where id = :id ";
        $params =['id'=>$id];
        try {
            $result = $this->conn->query($query, $params);
            $user = $result->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $this->setName($user['name']);
                $this->setEmail($user['email']);
                $this->setRole(Role::from($user['role']));
                $this->setStatus(UserStatus::from($user['status']));
            }
        } catch (PDOException $e) {
            error_log("Error logging in: " . $e->getMessage());
            return false;
        }
    }
    private function createObject($user){
        $object = new User();
       $object->setId($user['id']);
       $object->setName($user['name']);
       $object->setEmail($user['email']);
       $object->setCreatedAt($user['created_at']);
       $object->setStatus(UserStatus::from($user['status']));
       $object->setRole(Role::from($user['role']));
       return $object;
    }



}
