<?php

namespace core\base\controllers;

class ErrorController extends Controller
{
    public $message;

    public $code;

    public $stackTrace = '';

    public $params = [];

    public function __construct($message, $code, $stackTrace = '', $params = [])
    {
        $this->message = $message;
        $this->code = $code;
        $this->stackTrace = $stackTrace;
        $this->params = $params;
    }

    public function index()
    {
        echo '<h2>Внимание! Обнаружена ошибка.</h2>' .
            '<h4>' . 'Код: ' . $this->code . '</h4>' .
            '<h4>' . 'Заголовок: ' . $this->message . '</h4>';
        if (!empty($this->stackTrace)) {
            echo '<h4>Стек трейс:</h4>';
            echo $this->stackTrace;
        }
    }
}