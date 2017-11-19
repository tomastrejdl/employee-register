<?php

namespace Trejdl\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityManagerInterface;
use Trejdl\EmployeeBundle\Entity\Employee;
use Trejdl\EmployeeBundle\Entity\Role;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {

        return $this->render('TrejdlEmployeeBundle:AdminView:admin.html.twig', array(

        ));

    }

    /**
     * @Route("/admin/add-default-employees", name="admin-add-default-employees")
     */
    public function addDefaultEmployeesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $employeeLastNames = Array(
            "Smith", "Dollar"
        );
        $employeeFirstNames = Array(
            "Mark", "Steven"
        );


        $employees = Array();
        $employees[0]= new Employee;
        $employees[0]->setFirstName($employeeFirstNames[0]);
        $employees[0]->setLastName($employeeLastNames[0]);

        $employees[1]= new Employee;
        $employees[1]->setFirstName($employeeFirstNames[1]);
        $employees[1]->setLastName($employeeLastNames[1]);

        $i = 0;
        foreach($employees as $employee) {
            $employee->setEmail(strtolower(substr($employeeLastNames[$i],0,5).substr($employeeFirstNames[$i],0,3)."@example.com"));
            $employee->setPhone("123456789");
            $employee->setRoom("101");
            $roles = $em->getRepository(Role::class)->findAll();
            $role_id = array_rand($roles,1);
            $employee->addRole($roles[$role_id]);
            $em->persist($employee);
            $i++;
        }

        $em->flush();

        return $this->redirectToRoute("search");
    }
}