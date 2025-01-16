<?php


class StudentController extends BaseController
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
            $this->render('student');
        }else{
            $this->_404();
        }
    }

}
