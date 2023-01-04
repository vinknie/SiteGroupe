<?php

namespace App\Entity;

use App\Repository\PlanningSubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanningSubjectRepository::class)
 */
class PlanningSubject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Planning::class, inversedBy="planningSubjects")
     */
    private $planning;

    /**
     * @ORM\ManyToOne(targetEntity=Subject::class, inversedBy="planningSubjects")
     */
    private $subject;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startdate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $enddate;

    /**
     * @ORM\OneToMany(targetEntity=Absence::class, mappedBy="planningSubjects")
     */
    private $absences;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlanning(): ?Planning
    {
        return $this->planning;
    }

    public function setPlanning(?Planning $planning): self
    {
        $this->planning = $planning;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTimeInterface $enddate): self
    {
        $this->enddate = $enddate;

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
            $absences->setPlanningSubjects($this);
        }

        return $this;
    }

    public function removeAbsences(Absence $absences): self
    {
        if ($this->absences->contains($absences)) {
            $this->absences->removeElement($absences);
         
            if ($absences->getPlanningSubjects() === $this) {
                $absences->setPlanningSubjects(null);
            }
        }

        return $this;

    }   
}
