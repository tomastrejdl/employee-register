<?php

namespace Trejdl\EmployeeBundle\Service\Functionality;

use Doctrine\ORM\EntityManagerInterface;
use Trejdl\EmployeeBundle\Entity\Employee;
use Trejdl\EmployeeBundle\Entity\Account;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountFunctionality
{
    private $em;
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public function create(Account $account)
    {
        $plainPassword = $account->getPassword();
        $encoded = $this->encoder->encodePassword($account, $plainPassword);
        $account->setPassword($encoded);

        $this->em->persist($account);
        $this->em->flush();
    }

    public function update()
    {

    }

    public function delete($employee_id, $account_id)
    {
        $account =  $this->em->getRepository(Account::class)->find($account_id);
        $employee = $this->em ->getRepository(Employee::class)->find($employee_id);

        $employee->removeAccount($account);
        $this->em->remove($account);

        $this->em->flush();
    }
}