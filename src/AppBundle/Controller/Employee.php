<?php

namespace AppBundle\Controller;

class Employee
{
    public $username;
    public $firstName;
    public $lastName;
    public $position;
    public $email;
    public $tel;
    public $web;

    public function __construct($a = array()) {
        $this->username = strtolower(substr( $a[1], 0, 5) . substr( $a[0], 0, 3));
        $this->firstName = $a[0];
        $this->lastName = $a[1];
        $this->position = $a[2];
        $this->email = $this->username . "@company.com";
        $this->tel = $a[3];
        $this->web = $a[4];
    }

}