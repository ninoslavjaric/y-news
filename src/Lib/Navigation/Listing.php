<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/18/17
 * Time: 8:12 PM
 */

namespace Bravo\Lib\Navigation;


class Listing extends \ArrayIterator
{
    /**
     * @var string
     */
    private $key = "";

    /**
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }


    private function getPattern(){
        switch ($this->key){
            case "main":
                return "<div class=\"btn-group btn-group-justified menu menu-margin-top\" role=\"group\" aria-label=\"...\">{content}</div>";
            case "footer":
                return "<ul class=\"nav navbar-nav pull-right\">{content}</ul>";
            default:
                return "";
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $content = "";
        foreach ($this as $item){
            $content .= $item;
        }
        return str_replace("{content}", $content, $this->getPattern());
    }
}