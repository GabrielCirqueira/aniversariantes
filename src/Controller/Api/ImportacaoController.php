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
