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

        $form = $this->createForm(EmployeeType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();

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
        $repository = $this->getDoctrine()
            ->getRepository(Employee::class);
        $employee = $repository->findOneById($employee_id);

        if (!$employee)
            throw $this->createNotFoundException(
                'Employee with id: '.$employee_id.' does not exist!'
            );

        return $this->render('TrejdlEmployeeBundle:EmployeeView:detail.html.twig', array(
            "employee" => $employee
        ));
    }

    /**
     * @Route("/employee/{employee_id}/edit", name="employee-edit")
     */
    public function editAction($employee_id, Request $request)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Employee::class);
        $employee = $repository->findOneByid($employee_id);

        if (!$employee)
            throw $this->createNotFoundException(
                'Employee with id: '.$employee_id.' does not exist!'
            );

        $form = $this->createForm(EmployeeType::class, $employee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee = $form->getData();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee-detail', array('employee_id' => $employee_id) );
        }

        return $this->render('TrejdlEmployeeBundle:EmployeeView:edit.html.twig', array(
            "employee" => $employee,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/employee/delete/{employee_id}", name="employee-delete")
     */
    public function deleteAction($employee_id)
    {
        $em = $this->getDoctrine()->getManager();
        $employee =  $em->getRepository(Employee::class)->find($employee_id);

        if (!$employee)
            throw $this->createNotFoundException(
                'Employee with id: '.$employee_id.' does not exist!'
            );

        $em->remove($employee);
        $em->flush();

        return $this->redirectToRoute('search');
    }
}