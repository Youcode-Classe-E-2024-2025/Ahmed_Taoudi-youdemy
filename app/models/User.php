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

    public function __construct($name=null,$email=null,$password=null,UserStatus $status =UserStatus::PENDING ,Role $role =Role::STUDENT ,$created_at=null)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setStatus($status);
        $this->setRole($role);
        $this->setCreatedAt($created_at);
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

    public function setPassword($password): void
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

    public function read($id = 0, $status = 'active' ,$order = null): array
    {
        $users = [];
        $query = "SELECT u.* FROM $this->table  u WHERE u.role != 'admin' " ;
        $params = [];

        if ($status !== 'all') {
            $query .= " AND u.status = :user_status  ";
            $params[':user_status'] = UserStatus::from($status)->value;
        }

        if ($id) {
            $query .= " AND u.id = :id ";
            $params[':id'] = $id;
        }

        if ($order){
            $query .= " ORDER BY $order DESC ";
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

    // update (set status to $status ) delete howa archived 
    public function updateStatus($status): bool
    {
        $query = "UPDATE " . $this->table . "
                  SET status = :status
                  WHERE id = :id";

        $params = [
            ':status' => UserStatus::from($status)->value,
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
                $this->setId($user['id']);
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
        $object = new User($user['name'],$user['email'],'',UserStatus::from($user['status']),Role::from($user['role']),$user['created_at']);
       $object->setId($user['id']);
       return $object;
    }



}
