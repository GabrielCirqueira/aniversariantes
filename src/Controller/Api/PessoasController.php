<?php

namespace App\Controller\Api;

use App\Repository\PessoaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PessoasController extends AbstractController
{
    #[Route('v1/api/pessoas', name: 'app_get_pessoas')]
    public function getPessoas(
        Request $request,
        PessoaRepository $pessoaRepository
        ): JsonResponse {

        $apiKey = $request->headers->get('Authorization');
        $chaveCorreta = $_ENV['API_SECRET_KEY'];

        if (!$apiKey || $apiKey !== "Bearer " . $chaveCorreta) {
            return new JsonResponse(['error' => 'Acesso negado'], 403);
        }

        $pessoasOb = $pessoaRepository->findAll();

        $pessoas = [];
        $tipo = "Geral";

        foreach ($pessoasOb as $pessoa) {
            $pessoas[] = $pessoa->ToArray();
        }
        
        return $this->json([
            'Aniversariantes' => $tipo,
            'dados' => $pessoas
        ],  200, [], ['groups' => 'pessoa']);

    }
}
