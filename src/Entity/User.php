<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;



/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;
    
     /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password",message="Les mots de passe ne correspondent pas")
     */
    public $confirm_password;

     /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;


    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

   /**
     * @ORM\Column(name="lastname", type="string", length=255)
    */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $function;

    // cascade={"persist", "remove"}

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="users")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $classe;

         /**
     * @ORM\OneToMany(targetEntity=Exam::class, mappedBy="user")
     */
    private $exams; 

             /**
     * @ORM\OneToMany(targetEntity=Absence::class, mappedBy="user")
     */
    private $absences; 

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];


    public function __construct()
    {
        $this->isActive = true;
        $this->exams = new ArrayCollection();
        
    }

    public function getRoles() 
    { 
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $Roles): self
    {
        
        $this->roles = $Roles;
        return $this;


    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getSalt()
    {
        return null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstName): self
    {
        $this->firstname = $firstName;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastName): self
    {
        $this->lastname = $lastName;

        return $this;
    }


    public function getBirthdate(): ?\DateTimeInterface

    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }


    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function setFunction(string $function): self
    {
        $this->function = $function;


        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }




    
    
    public function eraseCredentials()
    {
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

      /**
     * @return Collection|Exam[]
     */
    public function getExams(): Collection
    {
        return $this->exams;
    }

    public function addExams(Exam $exams): self
    {
        if (!$this->exams->contains($exams)) {
            $this->exams[] = $exams;
            $exams->setUser($this);
        }

        return $this;
    }

    public function removeExams(Exam $exams): self
    {
        if ($this->exams->contains($exams)) {
            $this->exams->removeElement($exams);
         
            if ($exams->getUser() === $this) {
                $exams->setUser(null);
            }
        }

        return $this;
    }  
    
      /**
     * @return Collection|Absence[]
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsences(Absence $absences): self
    {
        if (!$this->absences->contains($absences)) {
            $this->absences[] = $absences;
            $absences->setUser($this);
        }

        return $this;
    }

    public function removeAbsences(Absence $absences): self
    {
        if ($this->absences->contains($absences)) {
            $this->absences->removeElement($absences);
         
            if ($absences->getUser() === $this) {
                $absences->setUser(null);
            }
        }

        return $this;
    }    

   

    public function __toString()
    {
        return $this->username;
        return $this->birthdate;
    }

}
