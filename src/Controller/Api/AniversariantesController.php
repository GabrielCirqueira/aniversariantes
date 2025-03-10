<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AniversariantesController extends AbstractController
{
    #[Route('v1/api/aniversariantes', name: 'app_api_aniversariantes_getaniversariantes')]
    public function getAniversariantes(EntityManagerInterface $entityManager): JsonResponse
    {
        $hoje = new \DateTime();
        $dia = $hoje->format('d');
        $mes = $hoje->format('m');

        $pessoas = $entityManager->getRepository('App\Entity\Pessoa')->findAll();

        $aniversariantes = [];
        $tipo = "diario";

        foreach ($pessoas as $pessoa) {

            $dataNascimento = $pessoa->getDataNascimento();
            if ($dataNascimento->format('d') == $dia && $dataNascimento->format('m') == $mes) {
                $aniversariantes[] = $pessoa->ToArray();
            }
        }


        if (empty($aniversariantes)) {

            $aniversariantes = array_filter($pessoas, function ($pessoa) use ($mes) {
                return $pessoa->getDataNascimento()->format('m') == $mes;
            });
            $aniversariantes = array_map(function ($pessoa) {
                return $pessoa->ToArray();
            }, $aniversariantes);
            
            $tipo = "mensal";
        }
 

        return $this->json([
            'Aniversariantes' => $tipo,
            'dados' => $aniversariantes
        ],  200, [], ['groups' => 'pessoa']);
    }
}
