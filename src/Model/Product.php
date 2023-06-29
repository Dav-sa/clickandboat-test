<?php

class Product
{
    public $title;
    public $city;
    public $model;
    public $builder;

    public function __construct($title, $city, $model, $builder)
    {
        $this->title = $title;
        $this->city = $city;
        $this->model = $model;
        $this->builder = $builder;
    }
}