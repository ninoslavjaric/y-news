<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/18/17
 * Time: 8:02 PM
 */

namespace Bravo\Lib\Navigation;


class Item
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $href;
    /**
     * @var boolean
     */
    private $active;

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
                return "<div class=\"btn-group\" role=\"group\"><a class=\"btn btn-default {active}\" href=\"{href}\">{title}</a></div>";
            case "footer":
                return "<li class=\"{active}\" ><a href=\"{href}\">{title}</a></li>";
            default:
                return "";

        }
    }
    /**
     * Item constructor.
     * @param string $title
     * @param string $href
     * @param bool $active
     */
    public function __construct($title, $href, $active)
    {
        $this->title = $title;
        $this->href = $href;
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return str_replace(
            ["{active}", "{href}", "{title}"],
            [$this->active?"active":"", $this->href, $this->title],
            $this->getPattern()
        );
    }

}