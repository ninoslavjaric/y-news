<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/15/17
 * Time: 11:55 AM
 */

namespace Bravo\Dto;


use Bravo\Lib\Dto;

class Rate extends Dto
{
    /**
     * @var Article
     */
    private $article;
    /**
     * @var string
     */
    private $value;
    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Rate
     */
    public function setValue(string $value): Rate
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Rate
     */
    public function setCreatedAt(\DateTime $createdAt): Rate
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param Article $article
     * @return Rate
     */
    public function setArticle(Article $article): Rate
    {
        $this->article = $article;
        return $this;
    }
}