<?php
namespace core\base\controllers;

use core\Page;
use core\View;

class Controller
{
    protected $layout = 'default';

    protected function render($view, $data = [])
    {
        $page = new Page($this->layout, $view, $data);
        $view =  new View($page);
        $view->render();
    }

    protected function renderView($view,$data = [])
    {
        $page = new Page($this->layout, $view, $data);
        $view =  new View($page);
        $view->renderView();
    }
}