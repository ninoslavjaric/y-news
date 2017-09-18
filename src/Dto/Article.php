<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:19 PM
 */

namespace Bravo\Dto;


use Bravo\Dao\Rate;
use Bravo\Lib\Arbeiter;
use Bravo\Lib\Cookie;
use Bravo\Lib\Dto;
use Bravo\Lib\Tool\Stringer;

/**
 * Class Article
 * @package Bravo\Dto
 */
class Article extends Dto
{
    /**
     * @var Category
     * @column category_id
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
     * @column pub_date
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
        if(!$this->category)
            $this->category = (\Bravo\Dao\Category::getInstance())
                ->getById($this->category_id);
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
        return Stringer::filterTitle($this->title);
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
    public function getTextDescription(): string
    {
        return Stringer::filterDescription(strip_tags($this->description));
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

    public function getImage(){
        if(preg_match('/<img[^>]+src="([^"]+)"[^>]+>/',$this->description, $matches))
            return $matches[1];
        return "/img/default.png";
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
        if(!$this->pubDate)
            $this->pubDate = (new \DateTime)->setTimestamp($this->pub_date);
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

    /**
     * @param bool $forse
     * @return float
     */
    public function getRating($forse = false)
    {
        if(!isset($this->rating) || $forse){
            /** @var Rate $rateDao */
            $rateDao = Rate::getInstance();
            if($forse)
                $rateDao->resetAvgByArticle($this);
            $this->rating = $rateDao->getAvgByArticle($this);
            $this->rating = $this->rating ? $this->rating : 0.00;
        }
        return $this->rating;
    }

    /**
     * @return bool
     */
    public function isRated(){
        return in_array($this->id, Cookie::getRatedArticles());
    }
}