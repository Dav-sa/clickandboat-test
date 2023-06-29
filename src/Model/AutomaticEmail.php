<?php

class AutomaticEmail
{
    public $id;
    public $subject;
    public $templates;

    public function __construct($id, $subject, $templates)
    {
        $this->id = $id;
        $this->subject = $subject;
        $this->templates = $templates;
    }
}