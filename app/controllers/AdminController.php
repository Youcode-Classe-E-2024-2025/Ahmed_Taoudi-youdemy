<?php


class AdminController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }


    public function index()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        if ($this->isGet()) {
            $content = "app/views/admin/dashboard.php";
            $this->render('admin',['content'=>$content]);
        }else{
            $this->_404();
        }
    }
    public function courses()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        if ($this->isGet()) {
            $content = "app/views/admin/courses.php";
            $this->render('admin',['content'=>$content]);
        }else{
            $this->_404();
        }
    }
    public function categories()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        if ($this->isGet()) {
            $content = "app/views/admin/categories.php";
            $this->render('admin',['content'=>$content]);
        }else{
            $this->_404();
        }
    }
    public function tags()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        if ($this->isGet()) {
            $content = "app/views/admin/tags.php";
            $this->render('admin',['content'=>$content]);
        }else{
            $this->_404();
        }
    }

    public function statistics()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        if ($this->isGet()) {
            $content = "app/views/admin/statistics.php";
            $this->render('admin',['content'=>$content]);
        }else{
            $this->_404();
        }
    }

    public function users()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        if ($this->isGet()) {
            $content = "app/views/admin/users.php";
            $users = $this->userModel->read(null,true);
            $this->render('admin',['content'=>$content , 'users'=>$users]);
        }else{
            $this->_404();
        }
    }

}
