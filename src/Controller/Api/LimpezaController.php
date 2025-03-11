<?php

namespace App\Controller\Api;

use App\Repository\PessoaRepository;
use App\Repository\CargoRepository;
use App\Repository\TurmaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LimpezaController extends AbstractController
{
    #[Route('/api/limpar-banco', name: 'limpar_banco', methods: ['DELETE'])]
    public function limparBanco(
        Request $request,
        EntityManagerInterface $entityManager,
        PessoaRepository $pessoaRepository,
        CargoRepository $cargoRepository,
        TurmaRepository $turmaRepository
    ): JsonResponse {
        
        $apiKey = $request->headers->get('Authorization');
        $chaveCorreta = $_ENV['API_SECRET_KEY'];

        if (!$apiKey || $apiKey !== "Bearer " . $chaveCorreta) {
            return new JsonResponse(['error' => 'Acesso negado'], 403);
        }

        $pessoas = $pessoaRepository->findAll();
        $cargos = $cargoRepository->findAll();
        $turmas = $turmaRepository->findAll();

        foreach ($pessoas as $pessoa) {
            $entityManager->remove($pessoa);
        }

        foreach ($cargos as $cargo) {
            $entityManager->remove($cargo);
        }

        foreach ($turmas as $turma) {
            $entityManager->remove($turma);
        }

        $entityManager->flush();

        return new JsonResponse(['message' => 'Todos os dados foram apagados'], 200);
    }
}
