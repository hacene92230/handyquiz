<?php

namespace App\Entity;

use App\Repository\QuizreplyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizreplyRepository::class)
 */
class Quizreply
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
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valide;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="quizreplies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quiz;

    /**
     * @ORM\Column(type="string", length=400)
     */
    private $verifcode;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="quizreply")
     */
    private $choix;

    public function __construct()
    {
        $this->choix = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getVerifcode(): ?string
    {
        return $this->verifcode;
    }

    public function setVerifcode(string $verifcode): self
    {
        $this->verifcode = $verifcode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getChoix(): Collection
    {
        return $this->choix;
    }

    public function addChoix(Reponse $choix): self
    {
        if (!$this->choix->contains($choix)) {
            $this->choix[] = $choix;
            $choix->setQuizreply($this);
        }

        return $this;
    }

    public function removeChoix(Reponse $choix): self
    {
        if ($this->choix->removeElement($choix)) {
            // set the owning side to null (unless already changed)
            if ($choix->getQuizreply() === $this) {
                $choix->setQuizreply(null);
            }
        }

        return $this;
    }
}
