<?php

namespace Trejdl\EmployeeBundle\Service\Functionality;

use Doctrine\ORM\EntityManagerInterface;
use Trejdl\EmployeeBundle\Entity\Employee;
use Trejdl\EmployeeBundle\Entity\Role;

class RoleFunctionality
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}