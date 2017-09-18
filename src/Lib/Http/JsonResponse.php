<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 3:49 PM
 */

namespace Bravo\Lib\Http;


class JsonResponse extends Response
{
    protected $contentType = "application/json";
    protected $statusCode;
    public function __construct(array $content, int $statusCode = 200)
    {
        parent::__construct($content);
        $this->statusCode = $statusCode;
        http_response_code($statusCode);
    }

    public function __toString()
    {
        return json_encode($this->content);
    }
}