<?php


abstract class Email
{
    /**
     * @var string
     */
    private $to = '';

    /**
     * @var string
     */
    private $from = '';

    /**
     * @var string
     */
    private $subject = '';

    /**
     * @var string
     */
    private $body = '';

    /**
     * @var string
     */
    private $headers = [];

    /**
     * @var array
     */
    private $placeholder = [];

    /**
     * @param $to
     * @param $from
     * @param $subject
     * @param $body
     * @param $placeholder
     */
    public function __construct($to, $from, $subject, $body, $placeholder){
        $this
            ->setTo($to)
            ->setFrom($from)
            ->setSubject($subject)
            ->setPlaceholder($placeholder)
            ->setBody($body);
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }


    /**
     * @param $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;
        $this->setHeaders('From: ' . $from . ' <' . $from . '>' . "\r\n");
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {

        foreach($this->getPlaceholder() as $key => $value){
            $body = str_replace('[+'.strtolower($key).'+]', $value, $body);
        }

        $this->body = $body;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        return implode("\r\n", $this->headers);
    }

    /**
     * @param $header
     * @return $this
     */
    private function setHeaders($header){
        $this->headers[] = $header;
        return $this;
    }

    /**
     * @return array
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

}