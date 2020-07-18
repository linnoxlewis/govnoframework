<?php

namespace core;

use core\base\abstracts\ViewInterface;

/**
 * Class for show user data
 *
 * Class View
 *
 * @package core
 */
class View implements ViewInterface
{
    /**
     * Page data
     *
     * @var Page
     */
    public $page;

    /**
     * View constructor.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Show controllers`s page
     *
     * @return mixed|void
     *
     * @throws \Throwable
     */
    public function render()
    {
        try {
            $page = $this->page;
            $layoutPath = VIEW_PATH . 'layouts' . DIRECTORY_SEPARATOR . "{$page->layout}.php";
            if (!file_exists($layoutPath)) {
                throw new \Exception("Layout $page->layout.php not found in $layoutPath", 404);
            }
            $obInitialLevel = ob_get_level();
            ob_start();
            require_once $layoutPath;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obInitialLevel) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }

    /**
     * Show custom page
     *
     * @return mixed|void
     *
     * @throws \Throwable
     */
    public function renderView()
    {
        try {
            $page = $this->page;
            $viewPath = ROOT_DIR . 'views' . DIRECTORY_SEPARATOR . $page->view . DIRECTORY_SEPARATOR . "$page->view.php";
            if (!file_exists($viewPath)) {
                throw new \Exception("View $page->view.php not found in $viewPath", 404);
            }
            extract($page->data, EXTR_OVERWRITE);
            ob_start();
            require_once $viewPath;
        } catch (\Throwable $e) {
            ob_clean();
            throw $e;
        }
    }

    /**
     * Show dinamic view in layout
     *
     * @return mixed|void
     *
     * @throws \Throwable
     */
    public function getContents()
    {
        $this->renderView();
    }
}
