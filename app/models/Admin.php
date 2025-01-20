<?php 
require_once 'app/models/User.php';
// Admin Class
class Admin extends User
{
    public function createUser( User $u ){
        return $u->create();
    }

}
