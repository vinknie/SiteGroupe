<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanningRepository::class)
 */
class Planning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;


    /**
     * @ORM\OneToOne(targetEntity=Classe::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $class;

    /**
     * @ORM\OneToMany(targetEntity=PlanningSubject::class, mappedBy="planning")
     */
    private $planningSubjects;



    public function __construct()
    {
        $this->subjectId = new ArrayCollection();
        $this->planningSubjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }



    public function getClass(): ?Classe
    {
        return $this->class;
    }

    public function setClass(Classe $class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return Collection|PlanningSubject[]
     */
    public function getPlanningSubjects(): Collection
    {
        return $this->planningSubjects;
    }

    public function addPlanningSubject(PlanningSubject $planningSubject): self
    {
        if (!$this->planningSubjects->contains($planningSubject)) {
            $this->planningSubjects[] = $planningSubject;
            $planningSubject->setPlanning($this);
        }

        return $this;
    }

    public function removePlanningSubject(PlanningSubject $planningSubject): self
    {
        if ($this->planningSubjects->contains($planningSubject)) {
            $this->planningSubjects->removeElement($planningSubject);
            // set the owning side to null (unless already changed)
            if ($planningSubject->getPlanning() === $this) {
                $planningSubject->setPlanning(null);
            }
        }

        return $this;
    }

  
}
