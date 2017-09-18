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
    public function __construct(array $content)
    {
        parent::__construct($content, "index/index");
    }

    public function __toString()
    {
        return json_encode($this->content);
    }
}