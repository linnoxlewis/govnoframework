<?php
namespace controllers;

use core\base\controllers\Controller;
use models\TestActiveRecord;

class TestController extends Controller
{
   public function check()
   {
      $this->renderView('test',['test'=>'test1','qwerty' => 'qwerty1']);
   }

   public function index()
   {
       $users = \App::$service->db->getFieldsName('users');
       var_dump($users);die();
       $model = new TestActiveRecord();
       $model->name= 23;
       var_dump($model->name);
       //var_dump($model->findAll([['>','id',2],['<','id',10]],['id','name']));
       //var_dump($model->findOne([['>','id',2],['<','id',10]],['id','name']));
   }
}