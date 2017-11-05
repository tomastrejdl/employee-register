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
use Trejdl\EmployeeBundle\Form\AccountType;

class MyAccountsController extends Controller
{
    /**
     * @Route("/my-accounts/list/{employee_id}", name="my-accounts-list")
     */
    public function listAction($employee_id)
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

        return $this->render('TrejdlEmployeeBundle:MyAccountsView:list.html.twig', array(
            "accounts" => $accounts,
            "employee" => $employee
        ));
    }

    /**
     * @Route("/my-accounts/create", name="my-accounts-create")
     */
    public function createAction(Request $request)
    {
        $account = new Account;

        $form = $this->createForm(AccountType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $account = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($account);
            $em->flush();

            return $this->redirectToRoute('my-accounts-list', array('employee_id' => $account->getEmployee()->getId() ));
        }

        return $this->render('TrejdlEmployeeBundle:MyAccountsView:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/my-accounts/edit/{account_id}", name="my-accounts-edit")
     */
    public function editAction(Request $request, $account_id)
    {
        $em = $this->getDoctrine()->getManager();
        $account =  $em->getRepository(Account::class)->find($account_id);

        $form = $this->createForm(AccountType::class, $account);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $account = $form->getData();
            $em->flush();

            return $this->redirectToRoute('my-accounts-list', array('employee_id' => $account->getEmployee()->getId() ));
        }

        return $this->render('TrejdlEmployeeBundle:MyAccountsView:edit.html.twig', array(
            'form' => $form->createView(),
            'account' => $account,
            'employee_id' => $account->getEmployee()->getId()
        ));
    }

    /**
     * @Route("/my-accounts/delete/{employee_id}?{account_id}", name="my-accounts-delete")
     */
    public function deleteAction($employee_id, $account_id)
    {
        $em = $this->getDoctrine()->getManager();
        $account =  $em->getRepository(Account::class)->find($account_id);

        if (!$account)
            throw $this->createNotFoundException(
                'Account with id: '.$account_id.' does not exist!'
            );

        $em->remove($account);
        $em->flush();

        return $this->redirectToRoute('my-accounts-list', array('employee_id' => $employee_id ));
    }
}