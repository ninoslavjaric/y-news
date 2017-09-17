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
     * @var string
     */
    private $title;

    /**
     * @var Article[]
     */
    private $articles = [];

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
     * @param null $orderKey
     * @param bool $ascending
     * @param null $limit
     * @param int $offset
     * @return array
     */
    public function getArticles($orderKey = null, $ascending = true, $limit = null, $offset = 0): array
    {
        if(!$this->articles)
            $this->articles = (\Bravo\Dao\Article::getInstance())
                ->getBy("category_id", $this->id, false, $orderKey, $ascending, $limit, $offset);
        return $this->articles;
    }

    /**
     * @param Article[] $articles
     * @return Category
     */
    public function setArticles(array $articles): Category
    {
        $this->articles = $articles;
        return $this;
    }

}