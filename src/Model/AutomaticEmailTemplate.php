<?php

class AutomaticEmailTemplate
{
    use SingletonTrait;

    public $content;
    public $signature;
    public $language;
    public $isEnabled;

    public function __construct($content = null, $signature = null, $language = null, $isEnabled = null)
    {
        $this->content = $content;
        $this->signature = $signature;
        $this->language = $language;
        $this->isEnabled = $isEnabled;
    }
}