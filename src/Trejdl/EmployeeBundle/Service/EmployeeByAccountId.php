<?php

namespace Trejdl\EmployeeBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Trejdl\EmployeeBundle\Entity\Account;

class EmployeeByAccountId
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function get($account_id)
    {
       return $this->em->getRepository(Account::class)->find($account_id)->getEmployee();
    }
}