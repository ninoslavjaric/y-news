<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 3:49 PM
 */

namespace Bravo\Lib\Http;


use Bravo\Lib\Arbeiter;
use Bravo\Lib\Config;
use Bravo\Lib\Traits\Navigator;
use Bravo\Lib\View;

class Response
{
    use Navigator;
    /**
     * @var string
     */
    protected $contentType = "text/html";
    /**
     * @var integer
     */
    protected $statusCode;
    /**
     * @var array
     */
    protected $content;
    /**
     * @var string
     */
    protected $view;
    /**
     * @var Request
     */
    protected $request;

    /**
     * Response constructor.
     * @param array $content
     * @param string $view
     * @param int $statusCode
     */
    public function __construct(array $content, string $view = "index/index", int $statusCode = 200)
    {
        header("Content-type: {$this->contentType}");
        http_response_code($statusCode);
        $this->statusCode = $statusCode;
        $this->content = $content;
        $this->view = $view;
    }

    /**
     * @param array $content
     * @return $this
     */
    public function setContent(array $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param string $view
     * @return $this
     */
    public function setView(string $view)
    {
        $this->view = $view;
        return $this;
    }

    public function __toString()
    {
        return (new View($this->view, $this->content))->setResponse($this)->spitLayout();
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function setRequest(Request $request)
    {
        if($navigations = Config::get('app.navigation'))
            $this->content = array_merge($this->content, $this->getNavigations($navigations, $request->getPath()));
        $this->request = $request;
        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }


}