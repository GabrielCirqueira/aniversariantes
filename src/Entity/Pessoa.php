<?php 

namespace App\Entity;

use App\Repository\PessoaRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PessoaRepository::class)]
class Pessoa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups('pessoa')]
    private string $nome;

    #[Groups('pessoa')]
    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $dataNascimento;

    #[ORM\ManyToOne(targetEntity: Cargo::class, inversedBy: "pessoas")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('pessoa')]
    private Cargo $cargo;

    #[ORM\ManyToOne(targetEntity: Turma::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('pessoa')]
    private ?Turma $turma = null;

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

    public function getDataNascimento(): \DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(DateTime $data): static
    {
        $this->dataNascimento = $data;

        return $this;
    }

    public function getCargo(): Cargo
    {
        return $this->cargo;
    }

    public function setCargo(Cargo $cargo): static
    {
        $this->cargo = $cargo;

        return $this;
    }

    public function getTurma(): ?Turma
    {
        return $this->turma;
    }

    public function setTurma(?Turma $turma): static
    {
        $this->turma = $turma;

        return $this;
    }

    public function getDataNascimentoFormatada(): string
    {
        return $this->dataNascimento ? $this->dataNascimento->format('d/m/Y') : '';
    }

    public function ToArray(): array
    {
        return [
            'nome' => $this->nome,
            'dataNascimento' => $this->getDataNascimentoFormatada(),
            'cargo' => [
                'id' => $this->getCargo()->getId(),
                'nome' => $this->getCargo()->getNome(),
            ],
            'turma' => $this->getTurma() ?
            [
                'id' => $this->getTurma()->getId(),
                $this->getTurma()->getNome()
            ] : null,
        ];
    }
}
