<?php

class TagController extends BaseController
{
    private Tag $tagModel;

    public function __construct()
    {
        parent::__construct();
        $this->tagModel = new Tag();
    }

    public function create()
    {
        $this->requireRole(Role::ADMIN);
        if ($this->isPost()) {
            // Verify CSRF token
            $token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCSRFToken($token)) {
                $this->setFlashMessage('error', 'CSRF token validation failed. Possible CSRF attack.');
                Security::regenerateCSRFToken();
                $this->redirect('/admin/tags');
            }
            // Debug::dd($_POST['tags'] );
            $validator = new Validator();
            // $a='';
            // $validator->validateName($a) ;
            $validator->validateArrayOfString($_POST['tags'], 'tous les champs de catégorie');
            if ($validator->isValid()) {
                $tags = [];
                foreach ($_POST['tags'] as $tg) {
                    $tags[] = new Tag($tg);
                }
                // Debug::pd($tags);
                if ($this->tagModel->create($tags)) {

                    $this->setFlashMessage('message', 'tags ajouté avec succès.');
                } else {

                    $this->setFlashMessage('error', ' ajoute de tags a échoué. Veuillez réessayer .');
                }
            } else {
                $_SESSION['errors'] = $validator->getErrors();
            }
            $this->redirect('/admin/tags');
        } else {
            $this->_404();
        }
    }

    public function delete()
    {
        if ($this->isPost()) {
            $token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCSRFToken($token)) {
                $this->setFlashMessage('error', 'CSRF token validation failed. Possible CSRF attack.');
                Security::regenerateCSRFToken();
                $this->redirect('/login');
            }
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $this->tagModel->setId($id);
            if ($this->tagModel->delete()) {
                $this->setFlashMessage('message', ' suprresion de tag avec succès');
            } else {
                $this->setFlashMessage('error', 'suprresion de tag  a échoué');
            }
            $this->redirect("/admin/tags");
        } else {
            $this->_404();
        }
    }
}
