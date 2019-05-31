<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Voiture;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MarqueController extends Controller
{
    /**
     * Finds and displays a marque entity.
     *
     * @Route(
     *     "/marque/{slug}/{page}",
     *     name="marque.show",
     *     methods="GET",
     *     defaults={"page": 1},
     *     requirements={"page" = "\d+"}
     * )
     *
     * @param Marque $marque
     * @param int $page
     * @param PaginatorInterface $paginator
     *
     * @return Response
     */
    public function show(
        Marque $marque,
        int $page,
        PaginatorInterface $paginator
    ) : Response {
        $disponibleVoitures = $paginator->paginate(
            $this->getDoctrine()->getRepository(Voiture::class)->getPaginatedDisponibleVoituresByMarqueQuery($marque),
            $page,
            $this->getParameter('max_jobs_on_category')
        );

        return $this->render('marque/show.html.twig', [
            'marque' => $marque,
            'disponibleVoitures' => $disponibleVoitures,
            
        ]);
    }
}