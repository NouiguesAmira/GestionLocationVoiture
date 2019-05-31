<?php

namespace App\Controller\Admin;

use App\Entity\Voiture;
use App\Form\Admin\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class VoitureController extends AbstractController
{
    /**
     * Lists all voitures entities.
     *
     * @Route("/admin/voitures/1+{page}",
     *     name="admin.voiture.list",
     *     methods="GET",
     *     defaults={"page": 1},
     *     requirements={"page" = "\d+"}
     * )
     *
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param int $page
     *
     * @return Response
     */
    public function list(EntityManagerInterface $em, PaginatorInterface $paginator, int $page): Response
    {
        $voitures = $paginator->paginate(
            $em->getRepository(Voiture::class)->createQueryBuilder('j'),
            $page,
            $this->getParameter('max_per_page'),
            [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'j.id',
                PaginatorInterface::DEFAULT_SORT_DIRECTION => 'DESC',
            ]
        );

        return $this->render('admin/voiture/list.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    /**
     * Create voiture.
     *
     * @Route("/admin/voiture/create", name="admin.voiture.create", methods="GET|POST")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($voiture);
            $em->flush();
            $voitures = $em->getRepository(Voiture::class)->findAll();

            return $this->redirectToRoute('admin.voiture.list');
        }

        return $this->render('admin/voiture/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit voiture.
     *
     * @Route("/admin/voiture/{id}/edit", name="admin.voiture.edit", methods="GET|POST")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Voiture $voiture
     *
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $em, Voiture $voiture): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $voitures = $em->getRepository(Voiture::class)->findAll();

            return $this->redirectToRoute('admin.voiture.list');
        }

        return $this->render('admin/voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }



    /**
     * Delete voiture.
     *
     * @Route("/admin/voiture/{id}/delete", name="admin.voiture.delete", methods="DELETE", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Voiture $voiture
     *
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em, Voiture $voiture): Response
    {
        if ($this->isCsrfTokenValid('delete' . $voiture->getId(), $request->request->get('_token'))) {
            $em->remove($voiture);
            $em->flush();
        }

        return $this->redirectToRoute('admin.voiture.list');
    }
}
