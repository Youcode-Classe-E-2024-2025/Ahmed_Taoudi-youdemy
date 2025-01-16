<?php

require_once 'app/models/User.php';
require_once "app/enums/Role.php";
require_once "app/enums/UserStatus.php";


class AuthController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function login()
    {
        // Redirect if the user is already logged in
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }
    
        // Handle POST request
        if ($this->isPost()) {
            // Verify CSRF token
            $token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCSRFToken($token)) {
                $this->setFlashMessage('error', 'CSRF token validation failed. Possible CSRF attack.');
                Security::regenerateCSRFToken();
                $this->redirect('/login');
            }
    
            // Sanitize inputs
            $email = Security::XSS($_POST['email']);
            $password = $_POST['password'];
    
            // Validate inputs
            $validator = new Validator();
            $validator->validateEmail($email);
            $validator->validatePassword($password);
    
            if ($validator->isValid()) {
                
                $user = $this->userModel->login($email, $password);
    
                if ($user) {
                    $roleEnum = Role::from($user['role']);
    
                    // Store in session
                    $_SESSION['user'] = $user;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $roleEnum->value; 

                    $this->setFlashMessage('message', 'Login successful. Welcome back! ' . $user['name']);
    
                    if ($roleEnum === Role::TEACHER) {
                        $this->redirect('/teacher/dashboard');
                    }else if ($roleEnum === Role::ADMIN) {
                        $this->redirect('/admin/dashboard');
                    } else {
                        $this->redirect('/student/dashboard');
                    }
                } else {
                    $this->setFlashMessage('error', 'Invalid email or password.');
                    $this->redirect('/login');
                }
            } else {
                // Validation failed
                $_SESSION['errors'] = $validator->getErrors();
                $_SESSION['old'] = [
                    'email' => $email,
                ];
                $this->redirect('/login');
            }
        }
    
        // Render the login form
        $this->render('login');
    }

    public function register()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }
        if ($this->isPost()) {
            // Debug::dd($_POST);
            $token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCSRFToken($token)) {
                $this->setFlashMessage('error', 'CSRF token validation failed. Possible CSRF attack.');
                Security::regenerateCSRFToken();
                $this->redirect('/login');
            }

            $name = Security::XSS($_POST['name']);
            $email = Security::XSS($_POST['email']);
            $role = Security::XSS($_POST['role']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            //  Validator 
            $validator = new Validator();

            // validation
            $validator->validateName($name);
            $validator->validateEmail($email);
            $validator->validatePassword($password);
            $validator->validateConfirmPassword($password, $confirm_password);
            $validator->validateRole($role);

            if ($validator->isValid()) {

                $this->userModel->setName($name);
                $this->userModel->setEmail($email);
                $this->userModel->setPassword(password_hash($password, PASSWORD_BCRYPT));

                // role & status
                    $roleEnum = Role::from($role); 
                    $this->userModel->setRole($roleEnum);

                    // status (ACTIVE , students)  (PENDING , Teachers )  
                    if ($roleEnum === Role::STUDENT) {
                        $this->userModel->setStatus(UserStatus::ACTIVE);
                    } elseif ($roleEnum === Role::TEACHER) {
                        $this->userModel->setStatus(UserStatus::PENDING);
                    } else {
                        $this->userModel->setStatus(UserStatus::ACTIVE);
                    }
                if ($this->userModel->create()) {
                    $this->setFlashMessage('message', 'Registration successful. Please login.');

                    $this->redirect('/login');
                } else {
                    $this->setFlashMessage('error', 'Registration failed. Please try again.');
                    $this->redirect('/register');
                }
            } else {

                $_SESSION['errors'] = $validator->getErrors();
                $_SESSION['old'] = [
                    'name' => $name,
                    'email' => $email,
                    'role' => $role,
                ];
                $this->redirect('/register');
            }
        }

        $this->render('register');
    }

    public function logout()
    {
        if ($this->isLoggedIn()) {
            session_unset();
            session_destroy();
            session_start();
            $_SESSION['message'] = 'You have been logged out successfully';
        }
        $this->redirect('/login');
    }
}
