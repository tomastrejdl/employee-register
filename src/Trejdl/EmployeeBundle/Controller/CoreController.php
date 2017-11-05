<?php

namespace Trejdl\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityManagerInterface;
use Trejdl\EmployeeBundle\Entity\Employee;


class CoreController extends Controller
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
        return $this->render('TrejdlEmployeeBundle:CoreView:homepage.html.twig', array(
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

        return $this->render('TrejdlEmployeeBundle:CoreView:search.html.twig', array(
            "employees" => $employees,
            "colors" => $this->colors
        ));
    }
}
