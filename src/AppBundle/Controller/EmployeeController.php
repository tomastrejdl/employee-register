<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\Employee;

class EmployeeController extends Controller
{
    public $allEmployees;

    public function __construct() {
        $this -> allEmployees = array(
            new Employee(array('Mark', 'Smith', 'Boss', '432987234', '')),
            new Employee(array('Steven', 'Dollar', 'PHP developer', '894092420', 'www.dollar.com')),
            new Employee(array('Micheal', 'Black', 'UI/UX Designer', '778009345', 'www.blackdesign.com')),
            new Employee(array('Jane', 'Doe', 'Assistant manager', '123456789', '')),
            new Employee(array('Maggie', 'Jones', 'PR manager', '889330224', '')),
            new Employee(array('Collin', 'English', 'Sanitor', '765091128', ''))

        );
    }
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Employee:homepage.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/search", name="search")
     */
    public function searchAction()
    {
        return $this->render('AppBundle:Employee:search.html.twig', array(
            "employees" => $this -> allEmployees
        ));
    }

    /**
     * @Route("/detail/{employee_id}", name="detail")
     */
    public function detailAction($employee_id)
    {
        return $this->render('AppBundle:Employee:detail.html.twig', array(
            "employee" => $this -> allEmployees[$employee_id],
            "employee_id" => $employee_id
        ));
    }

    /**
     * @Route("/detail/{employee_id}/edit", name="edit")
     */
    public function editAction($employee_id)
    {
        return $this->render('AppBundle:Employee:edit.html.twig', array(
            "employee" => $this -> allEmployees[$employee_id],
            "employee_id" => $employee_id
        ));
    }

    public function searchEmployees($username){
        foreach ( $this->allEmployees as $employee) {
            if ($username == $employee.username)
                return $employee;
        }
        return false;
    }

}
