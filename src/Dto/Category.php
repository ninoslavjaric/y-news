<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:19 PM
 */

namespace Bravo\Dto;


use Bravo\Lib\Dto;

class Category extends Dto
{
    /**
     * @var string
     */
    private $key;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Category
     */
    public function setKey(string $key): Category
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Category
     */
    public function setTitle(string $title): Category
    {
        $this->title = $title;
        return $this;
    }
    /**
     * @var string
     */
    private $title;
}