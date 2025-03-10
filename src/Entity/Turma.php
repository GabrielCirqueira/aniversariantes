<?php 

namespace App\Entity;

use App\Repository\TurmaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TurmaRepository::class)]
class Turma
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $nome;

    #[ORM\OneToMany(mappedBy: "turma", targetEntity: Pessoa::class)]
    private Collection $estudantes;

    
    public function __construct()
    {
        $this->estudantes = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEstudantes(): Collection
    {
        return $this->estudantes;
    }

}
