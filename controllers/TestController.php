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
       $model = new TestActiveRecord();
       //var_dump($model->findAll([['>','id',2],['<','id',10]],['id','name']));
       //var_dump($model->findOne([['>','id',2],['<','id',10]],['id','name']));
   }
}