<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/10/17
 * Time: 5:50 PM
 */

namespace Bravo\Lib;


use Bravo\Lib\Http\Response;

class View
{
    private $layout = PROJECT_ROOT."/view/layout.phtml";
    private $view;
    /**
     * @var Response
     */
    private $response;

    /**
     * View constructor.
     * @param string $viewPath
     * @param array $data
     */
    public function __construct(string $viewPath, array $data)
    {
        ob_start();
        $this->view = PROJECT_ROOT."/view/{$viewPath}.phtml";
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
        $content = $this->getTemplate($this->view);
        return $content;
    }

    /**
     * @return string
     */
    public function spitLayout() : string
    {
        $content = $this->getTemplate($this->layout);
        return $content;
    }

    /**
     * @param $path
     * @return string
     */
    private function getTemplate($path) : string{
        include $path;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * @param Response $response
     * @return $this
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return Http\Request
     */
    public function getRequest(){
        return $this->response->getRequest();
    }

    public function getUrl(){
        return $this->getRequest()->getPath();
    }
}