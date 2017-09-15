<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:19 PM
 */

namespace Bravo\Dto;


use Bravo\Lib\Dto;

class Article extends Dto
{
    /**
     * @var Category
     */
    private $category;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $link;
    /**
     * @var \DateTime
     */
    private $pubDate;
    /**
     * @var string
     */
    private $source;
    /**
     * @var string
     */
    private $guid;

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Article
     */
    public function setCategory(Category $category): Article
    {
        $this->category = $category;
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
     * @return Article
     */
    public function setTitle(string $title): Article
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Article
     */
    public function setDescription(string $description): Article
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return Article
     */
    public function setLink(string $link): Article
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPubDate(): \DateTime
    {
        return $this->pubDate;
    }

    /**
     * @param \DateTime $pubDate
     * @return Article
     */
    public function setPubDate(\DateTime $pubDate): Article
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return Article
     */
    public function setSource(string $source): Article
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @param string $guid
     * @return Article
     */
    public function setGuid(string $guid): Article
    {
        $this->guid = $guid;
        return $this;
    }


}