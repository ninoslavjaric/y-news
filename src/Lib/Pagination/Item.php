<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/18/17
 * Time: 3:16 PM
 */

namespace Bravo\Lib\Pagination;


final class Item
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var boolean
     */
    private $disabled;
    /**
     * @var boolean
     */
    private $active;
    /**
     * @var string
     */
    private $url;

    /**
     * Item constructor.
     * @param string $title
     * @param bool $disabled
     * @param bool $active
     * @param string $url
     */
    public function __construct($title, $disabled, $active, $url)
    {
        $this->title = $title;
        $this->disabled = $disabled;
        $this->active = $active;
        $this->url = $url;
    }


    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function __toString()
    {
        if($this->active){
            $content = "<span class=\"page-link\">{$this->title}</span>";
            $li = "<li class=\"page-item active\">{$content}</li>";
        } elseif($this->disabled){
            $content = "<span class=\"page-link\">{$this->title}</span>";
            $li = "<li class=\"page-item disabled\">{$content}</li>";
        }else{
            $content = "<a class=\"page-link\" href=\"{$this->url}\">{$this->title}</a>";
            $li = "<li class=\"page-item\">{$content}</li>";
        }
        return $li;
    }


}