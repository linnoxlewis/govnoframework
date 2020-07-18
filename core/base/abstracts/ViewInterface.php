<?php
namespace core\base\abstracts;

/**
 * Interface view Class
 *
 * Interface ViewInterface
 *
 * @package core\base\abstracts
 */
interface ViewInterface
{
    /**
     * Show controllers`s page
     *
     * @return mixed
     */
    public function render();

    /**
     * Show custom page
     *
     * @return mixed|void
     *
     * @throws \Throwable
     */
    public function renderView();

    /**
     * Show dinamic view in layout
     *
     * @return mixed|void
     *
     * @throws \Throwable
     */
    public function getContents();
}
