<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubjectRepository::class)
 */
class Subject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Lessons::class, mappedBy="subject", orphanRemoval=true)
     */
    private $lessons;

    /**
     * @ORM\Column(type="integer")
     */
    private $coefficient;

    /**
     * @ORM\OneToMany(targetEntity=Exam::class, mappedBy="subject")
     */
    private $exams;

    /**
     * @ORM\OneToMany(targetEntity=PlanningSubject::class, mappedBy="subject")
     */
    private $planningSubjects;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->exams = new ArrayCollection();


    }


    public function getId(): ?int
    {
        return $this->id;
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
            $exams->setSubject($this);
        }

        return $this;
    }

    public function removeExams(Exam $exams): self
    {
        if ($this->exams->contains($exams)) {
            $this->exams->removeElement($exams);

            if ($exams->getSubject() === $this) {
                $exams->setSubject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Lessons[]
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lessons $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setSubject($this);
        }

        return $this;
    }

    public function removeLesson(Lessons $lesson): self
    {
        if ($this->lessons->contains($lesson)) {
            $this->lessons->removeElement($lesson);

            if ($lesson->getSubject() === $this) {
                $lesson->setSubject(null);
            }
        }

        return $this;
    }

    public function getCoefficient(): ?int
    {
        return $this->coefficient;
    }

    public function setCoefficient(int $coefficient): self
    {
        $this->coefficient = $coefficient;

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
            $planningSubject->setSubject($this);

        }

        return $this;
    }

    public function removePlanningSubject(PlanningSubject $planningSubject): self
    {
        if ($this->planningSubjects->contains($planningSubject)) {
            $this->planningSubjects->removeElement($planningSubject);
            // set the owning side to null (unless already changed)
            if ($planningSubject->getSubject() === $this) {
                $planningSubject->setSubject(null);

            }
            return $this;
        }
        

    
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
