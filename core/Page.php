<?php

namespace core;

class Page
{
    private $layout;
    private $view;
    private $data = [];

    public function __construct($layout, $view, $data)
    {
        $this->layout = $layout;
        $this->view   = $view;
        $this->data   = $data;

    }

    public function &__get($property)
    {
        return $this->$property;
    }
}
