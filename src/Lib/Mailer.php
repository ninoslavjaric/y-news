<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 2:41 AM
 */

namespace Bravo\Lib;


class Mailer
{
    private $to;
    private $subject;
    private $message;

    private $from;
    /**
     * @var string[]
     */
    private $additional_headers;

    /**
     * Mailer constructor.
     * @param $to
     * @param $subject
     * @param $message
     * @param $from
     */
    public function __construct($from, $to, $subject, $message)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->from = $from;
    }


    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     * @return Mailer
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     * @return Mailer
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return Mailer
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     * @return Mailer
     */
    public function setFrom($from)
    {
        $this->additional_headers[] = "From: {$from}";
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdditionalHeaders()
    {
        return $this->additional_headers;
    }

    /**
     * @param mixed $additional_headers
     * @return Mailer
     */
    public function setAdditionalHeaders($additional_headers)
    {
        $this->additional_headers = $additional_headers;
        return $this;
    }



    public function send(){
        return mail($this->to, $this->subject, $this->message, implode("\r\n", $this->additional_headers));
    }
}