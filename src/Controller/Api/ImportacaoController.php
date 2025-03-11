<?php 

namespace App\Controller\Api;

use App\Service\ImportarPessoasService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImportacaoController extends AbstractController
{
    #[Route('v1/api/importar-pessoas', methods: ['POST'])]
    public function importar(Request $request, ImportarPessoasService $importarPessoasService): JsonResponse
    {

        $apiKey = $request->headers->get('Authorization');
        $chaveCorreta = $_ENV['API_SECRET_KEY'];

        if (!$apiKey || $apiKey !== "Bearer " . $chaveCorreta) {
            return new JsonResponse(['error' => 'Acesso negado'], 403);
        }
        
        $dados = json_decode($request->getContent(), true);

        if (!is_array($dados)) {
            return new JsonResponse(['erro' => 'Formato JSON inválido'], 400);
        }

        $erros = $importarPessoasService->importar($dados);

        return new JsonResponse([
            'mensagem' => 'Importação concluída',
            'erros' => $erros,
        ]);
    }
}
