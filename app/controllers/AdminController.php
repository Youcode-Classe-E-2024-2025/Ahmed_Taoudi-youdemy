<?php


class AdminController extends BaseController
{
    public User $userModel;
    public Category $categoryModel;
    public Tag $tagModel;
    public Course $courseModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->categoryModel = new Category();
        $this->tagModel = new Tag();
        $this->courseModel = new Course();
    }


    public function index()
    {
        $this->requireRole(Role::ADMIN);

        if ($this->isGet()) {
            $content = "app/views/admin/dashboard.php";
            $this->render('admin', ['content' => $content]);
        } else {
            $this->_404();
        }
    }
    public function courses()
    {
        $this->requireRole(Role::ADMIN);
        if ($this->isGet()) {
            $limit = 12;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $count = $this->courseModel->getCount();
            // Debug::pd($count);
            $totalPages = ceil($count / $limit);
            // validation
            if ($page <= 0 || $page > $totalPages) {

                $page = 1;
            }
            $offset = $limit * ($page - 1);
            $content = "app/views/admin/courses.php";
            $courses = $this->courseModel->getCourses($limit, $offset);
            $this->render(
                'admin',
                [
                    'content' => $content,
                    'courses' => $courses,
                    'page' => $page,
                    'totalPages' => $totalPages
                ]
            );
        } else {
            $this->_404();
        }
    }
    public function categories()
    {
        $this->requireRole(Role::ADMIN);

        if ($this->isGet()) {
            $content = "app/views/admin/categories.php";
            $categorys = $this->categoryModel->getAllCategories();
            $this->render('admin', ['content' => $content, 'categorys' => $categorys]);
        } else {
            $this->_404();
        }
    }
    public function tags()
    {
        $this->requireRole(Role::ADMIN);

        if ($this->isGet()) {
            $content = "app/views/admin/tags.php";
            $tags = $this->tagModel->getAllTags();
            $this->render('admin', ['content' => $content, 'tags' => $tags]);
        } else {
            $this->_404();
        }
    }

    public function statistics()
    {
        $this->requireRole(Role::ADMIN);

        if ($this->isGet()) {
            $content = "app/views/admin/statistics.php";
            $this->render('admin', ['content' => $content]);
        } else {
            $this->_404();
        }
    }

    public function users()
    {
        $this->requireRole(Role::ADMIN);

        if ($this->isGet()) {
            $content = "app/views/admin/users.php";
            $status = $_GET['status'] ?? 'all';
            if (!UserStatus::tryFrom($status)) $status = 'all';
            $users = $this->userModel->read(null, $status, 'name'); // read(id,)
            $this->render('admin', ['content' => $content, 'users' => $users]);
        } else {
            $this->_404();
        }
    }

    public function updateStatus()
    {
        $this->requireRole(Role::ADMIN);
        if ($this->isPost()) {
            $token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCSRFToken($token)) {
                $this->setFlashMessage('error', 'CSRF token validation failed. Possible CSRF attack.');
                Security::regenerateCSRFToken();
                $this->redirect('/login');
            }
            $status = $_POST['status'] ?? 'sss';
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            if (UserStatus::tryFrom($status) && $id > 0) {
                // Debug::dd($_POST,$status,1);

                $this->userModel->setId($id);
                if ($this->userModel->updateStatus($status)) {
                    $this->setFlashMessage('message', ' update status avec succès');
                } else {
                    $this->setFlashMessage('error', 'update status a échoué');
                }
            } else {
                $this->setFlashMessage('error', 'update status a échoué');
            }
            $this->redirect("/admin/users?status=$status");
        } else {
            $this->_404();
        }
    }
}
