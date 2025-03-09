<?php

namespace App\Service;

use App\Entity\Pessoa;
use App\Entity\Cargo;
use App\Entity\Turma;
use Doctrine\ORM\EntityManagerInterface;

class ImportarPessoasService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function importar(array $dados): array
    {
        $erros = [];

        foreach ($dados as $index => $item) {
            $nome = $item['nome'] ?? null;
            $dataNascimentoStr = $item['data_nascimento'] ?? null;
            $nomeCargo = $item['cargo'] ?? null;
            $nomeTurma = $item['turma'] ?? null;

            if (!$nome || !$dataNascimentoStr || !$nomeCargo) {
                $erros[] = "Erro na linha $index: Nome, Data de Nascimento e Cargo sao obrigatorios.";
                continue;
            }

            $dataNascimento = \DateTime::createFromFormat('d/m/Y', $dataNascimentoStr);
            if (!$dataNascimento) {
                $erros[] = "Erro na linha $index: Data de nascimento inválida.";
                continue;
            }

            $cargoNome = $item['cargo'];

            $cargo = $this->entityManager->getRepository(Cargo::class)
                ->findOneBy(['nome' => $cargoNome]);

            if (!$cargo) {
                $cargo = new Cargo();
                $cargo->setNome($cargoNome);
                $this->entityManager->persist($cargo);
            }

            $turma = null;
            if (strtoupper($nomeCargo) === 'ALUNO') {
                if (!$nomeTurma) {
                    $erros[] = "Erro na linha $index: Aluno deve ter uma turma.";
                    continue;
                }

                $turma = $this->entityManager->getRepository(Turma::class)
                    ->findOneBy(['nome' => $nomeTurma]);

                if (!$turma) {
                    $turma = new Turma();
                    $turma->setNome($nomeTurma);
                    $this->entityManager->persist($turma);
                }
            }

            $pessoa = new Pessoa();
            $pessoa->setNome($nome);
            $pessoa->setDataNascimento($dataNascimento);
            $pessoa->setCargo($cargo);
            $pessoa->setTurma($turma);

            $this->entityManager->persist($pessoa);
            $this->entityManager->flush();
    }

        return $erros;
    }
}
