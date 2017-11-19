<?php

namespace Trejdl\EmployeeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="Trejdl\EmployeeBundle\Repository\RoleRepository")
 * @UniqueEntity("title")
 */
class Role
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="isVisible", type="boolean")
     * @Assert\NotBlank()
     */
    private $isVisible;

    /**
     * @var Employee[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Employee", mappedBy="roles")
     * @Assert\NotBlank()
     */
    private $employees;
    /**
     * Get id
     *
     * @return int
     */


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->employees = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Role
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Role
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     *
     * @return Role
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * Add employee
     *
     * @param \Trejdl\EmployeeBundle\Entity\Employee $employee
     *
     * @return Role
     */
    public function addEmployee(\Trejdl\EmployeeBundle\Entity\Employee $employee)
    {
        $this->employees[] = $employee;
        $employee->addRole($this);

        return $this;
    }

    /**
     * Remove employee
     *
     * @param \Trejdl\EmployeeBundle\Entity\Employee $employee
     */
    public function removeEmployee(\Trejdl\EmployeeBundle\Entity\Employee $employee)
    {
        $this->employees->removeElement($employee);
        $employee->removeRole($this);
    }

    /**
     * Get employees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployees()
    {
        return $this->employees;
    }
}
