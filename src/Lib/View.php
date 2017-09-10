<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/10/17
 * Time: 5:50 PM
 */

namespace Bravo\Lib;


class View
{
    private $layout = PROJECT_ROOT."/view/layout.php";
    private $view;

    /**
     * View constructor.
     * @param string $viewPath
     * @param array $data
     */
    public function __construct(string $viewPath, array $data)
    {
        $this->view = $viewPath;
        foreach ($data as $key => $item) {
            $this->{"$key"} = $item;
        }
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     * @return $this
     */
    public function setLayout(string $layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent() : string{
        return $this->getTemplate($this->view);
    }

    /**
     * @return string
     */
    public function spitLayout() : string
    {
        return $this->getTemplate($this->layout);
    }

    /**
     * @param $path
     * @return string
     */
    private function getTemplate($path) : string{
        ob_start();
        include $path;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}