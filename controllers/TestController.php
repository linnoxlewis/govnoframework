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
       var_dump($model->find()->where(['=','id',23])->one());
   }
}