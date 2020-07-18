<?php

namespace controllers;
use core\base\controllers\Controller;

class SiteController extends Controller
{
    public function index()
    {
       var_dump(\App::$service->db->select(['id','name'])->from('users')->in('id',[5,6,7])->andWhere('NOT LIKE','name','%Cris%')->one());
    }

}