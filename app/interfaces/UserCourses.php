<?php 

interface UserCourse 
{
    public function getMyCourses($limit=0,$offset=0);
    public function getCount();
}