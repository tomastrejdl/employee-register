<?php

namespace Trejdl\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityManagerInterface;
use Trejdl\EmployeeBundle\Entity\Employee;
use Trejdl\EmployeeBundle\Entity\Role;
use Trejdl\EmployeeBundle\Entity\Account;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Trejdl\EmployeeBundle\Form\EmployeeType;

class EmployeeController extends Controller
{
    /**
     * @Route("/employee/create", name="employee-create")
     */
    public function createAction(Request $request)
    {
        $employee = new Employee;
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('employee_functionality')->create($employee);

            return $this->redirectToRoute('employee-detail', array('employee_id' =>  $employee->getId() ));
        }

        return $this->render('TrejdlEmployeeBundle:EmployeeView:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/employee/{employee_id}", name="employee-detail")
     */
    public function detailAction($employee_id)
    {
        $em = $this->getDoctrine()->getManager();
        $employee =  $em->getRepository(Employee::class)->find($employee_id);
        $accounts = $em->getRepository(Account::class)->findByEmployee($employee_id);
        $roles = $employee->getRoles();

        if (!$employee)
            throw $this->createNotFoundException(
                'Employee with id: '.$employee_id.' does not exist!'
            );

        return $this->render('TrejdlEmployeeBundle:EmployeeView:detail.html.twig', array(
            "employee" => $employee,
            "accounts" => $accounts,
            "roles" => $roles
        ));
    }

    /**
     * @Route("/employee/{employee_id}/update", name="employee-update")
     */
    public function editAction($employee_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $employee = $em->getRepository(Employee::class)->find($employee_id);

        if (!$employee)
            throw $this->createNotFoundException(
                'Employee with id: '.$employee_id.' does not exist!'
            );

        $form = $this->createForm(EmployeeType::class, $employee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('employee-detail', array('employee_id' => $employee_id) );
        }

        return $this->render('TrejdlEmployeeBundle:EmployeeView:update.html.twig', array(
            "employee" => $employee,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/employee/{employee_id}/delete", name="employee-delete")
     */
    public function deleteAction($employee_id)
    {
        $this->get('employee_functionality')->delete($employee_id);

        return $this->redirectToRoute('search');
    }
}