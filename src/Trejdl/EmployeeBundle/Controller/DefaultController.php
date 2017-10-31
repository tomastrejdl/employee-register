<?php

namespace Trejdl\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityManagerInterface;
use Trejdl\EmployeeBundle\Entity\Employee;
use Trejdl\EmployeeBundle\Entity\Role;
use Trejdl\EmployeeBundle\Entity\Account;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    var $colors;

    public function __construct()
    {
        $this->colors = array(
            "deepPurple500" => "#673AB7",
            "indigo500" => "#3F51B5",
            "blue500" => "#2196F3",
            "teal500" => "#009688",
            "green500" => "#4CAF50",
            "blueGrey500" => "#607D8B"
        );
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('TrejdlEmployeeBundle:Homepage:homepage.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/search", name="search")
     */
    public function searchAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Employee::class);
        $employees = $repository->findAll();

        if (!$employees)
            throw $this->createNotFoundException(
                'No employees found'
            );

        return $this->render('TrejdlEmployeeBundle:Search:search.html.twig', array(
            "employees" => $employees,
            "colors" => $this->colors
        ));
    }

    /**
     * @Route("/detail/{employee_id}", name="detail")
     */
    public function detailAction($employee_id)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Employee::class);
        $employee = $repository->findOneById($employee_id);

        if (!$employee)
            throw $this->createNotFoundException(
                'Employee with id: '.$employee_id.' does not exist!'
            );

        return $this->render('TrejdlEmployeeBundle:Detail:detail.html.twig', array(
            "employee" => $employee
        ));
    }

    /**
     * @Route("/detail/{employee_id}/edit", name="edit")
     */
    public function editAction($employee_id)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Employee::class);
        $employee = $repository->findOneById($employee_id);

        if (!$employee)
            throw $this->createNotFoundException(
                'Employee with id: '.$employee_id.' does not exist!'
            );

        return $this->render('TrejdlEmployeeBundle:Detail:edit.html.twig', array(
            "employee" => $employee
        ));
    }

    /*
    public function searchEmployees($username){
        foreach ( $this->allEmployees as $employee) {
            if ($username == $employee.username)
                return $employee;
        }
        return false;
    }
    */

    /**
     * @Route("/create", name="create")
     */
    public function createAction()
    {
        $em = $this->getDoctrine()->getManager();

        $account = new Account;
        $account->setUsername("dollast2");
        $account->setPassword("12345");
        $account->setEmployee($em->getRepository(Employee::class)->find("5"));
        $em->persist($account);

        $em->flush();

        return new Response('Saved new account with id '.$account->getId());

    }

    /**
     * @Route("/accounts/{employee_id}", name="accounts")
     */
    public function accountsActions($employee_id)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Account::class);
        $accounts = $repository->findByEmployee($employee_id);

        $employee = $this->getDoctrine()->getRepository(Employee::class)
            ->find($employee_id);

        if (!$accounts)
            throw $this->createNotFoundException(
                'No accounts found for employee, with id: !' . $employee_id
            );

        return $this->render('TrejdlEmployeeBundle:Accounts:accounts.html.twig', array(
            "accounts" => $accounts,
            "employee" => $employee
        ));
    }

}
