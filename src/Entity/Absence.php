<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbsenceRepository::class)
 */
class Absence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

        /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="absences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

        /**
     * @ORM\ManyToOne(targetEntity=PlanningSubject::class, inversedBy="absences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $planningSubjects;    
    

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->planningSubjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPlanningSubjects(): ?PlanningSubject
    {
        return $this->planningSubjects;
    }

    public function setPlanningSubjects(?PlanningSubject $planningSubjects): self
    {
        $this->subject = $planningSubjects;

        return $this;
    }


}
