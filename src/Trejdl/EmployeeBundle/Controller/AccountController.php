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
use Trejdl\EmployeeBundle\Service\AccountFunctionality;

class AccountController extends Controller
{
    /**
     * @Route("/employee/{employee_id}/account/create", name="account-create")
     */
    public function createAction(Request $request, $employee_id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'Access denied!');

        $account = new Account;
        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);
        $account->setEmployee($employee);
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('account_functionality')->create($account);
            return $this->redirectToRoute('employee-detail', array('employee_id' => $account->getEmployee()->getId()));
        }
        return $this->render('TrejdlEmployeeBundle:AccountView:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/employee/{employee_id}/account/{account_id}/update", name="account-update")
     */
    public function updateAction(Request $request, $employee_id, $account_id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'Access denied!');

        $em = $this->getDoctrine()->getManager();
        $account =  $em->getRepository(Account::class)->find($account_id);
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('employee-detail', array('employee_id' => $account->getEmployee()->getId() ));
        }

        return $this->render('TrejdlEmployeeBundle:AccountView:update.html.twig', array(
            'form' => $form->createView(),
            'account' => $account,
            'employee_id' => $account->getEmployee()->getId()
        ));
    }

    /**
     * @Route("/employee/{employee_id}/account/{account_id}/delete", name="account-delete")
     */
    public function deleteAction($employee_id, $account_id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'Access denied!');

        $this->get('account_functionality')->delete($employee_id, $account_id);

        return $this->redirectToRoute('employee-detail', array('employee_id' => $employee_id ));
    }
}