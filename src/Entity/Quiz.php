<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuizRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Created_at;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class, inversedBy="quizzes")
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=Quizreply::class, mappedBy="quiz")
     */
    private $quizreplies;

    public function __construct()
    {
        $this->question = new ArrayCollection();
        $this->Created_at = new \DateTime();
        $this->quizreplies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->Created_at;
    }

    public function setCreatedAt(\DateTimeInterface $Created_at): self
    {
        $this->Created_at = $Created_at;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->question->contains($question)) {
            $this->question[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        $this->question->removeElement($question);

        return $this;
    }

    /**
     * @return Collection|Quizreply[]
     */
    public function getQuizreplies(): Collection
    {
        return $this->quizreplies;
    }

    public function addQuizreply(Quizreply $quizreply): self
    {
        if (!$this->quizreplies->contains($quizreply)) {
            $this->quizreplies[] = $quizreply;
            $quizreply->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizreply(Quizreply $quizreply): self
    {
        if ($this->quizreplies->removeElement($quizreply)) {
            // set the owning side to null (unless already changed)
            if ($quizreply->getQuiz() === $this) {
                $quizreply->setQuiz(null);
            }
        }

        return $this;
    }
}
