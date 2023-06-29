<?php

class User
{
    public $firstName;
    public $lastName;
    public $email;
    public $phone;

    public function __construct($firstName, $lastName, $email, $phone)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
    }
}