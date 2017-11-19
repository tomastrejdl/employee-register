<?php

namespace Trejdl\EmployeeBundle\Service\Functionality;

use Doctrine\ORM\EntityManagerInterface;
use Trejdl\EmployeeBundle\Entity\Employee;

class EmployeeFunctionality
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create($employee)
    {
        $this->em->persist($employee);
        $this->em->flush();
    }

    public function update()
    {

    }

    public function delete($employee_id)
    {
        $employee = $this->em->getRepository(Employee::class)->find($employee_id);
        if(!$employee) {
            //not found
        }
        $this->em->remove($employee);
        $this->em->flush();
    }
}