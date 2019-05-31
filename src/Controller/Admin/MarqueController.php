<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use App\Form\Admin\MarqueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MarqueController extends AbstractController
{
    /**
     * Lists all marques entities.
     *
     * @Route("/admin/marques", name="admin.marque.list", methods="GET")
     *
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function list(EntityManagerInterface $em): Response
    {
        $marques = $em->getRepository(Marque::class)->findAll();

        return $this->render('admin/marque/list.html.twig', [
            'marques' => $marques,
        ]);
    }

    /**
     * Create marque.
     *
     * @Route("/admin/marque/create", name="admin.marque.create", methods="GET|POST")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($marque);
            $em->flush();

            return $this->redirectToRoute('admin.marque.list');
        }

        return $this->render('admin/marque/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit marque.
     *
     * @Route("/admin/marque/{id}/edit", name="admin.marque.edit", methods="GET|POST", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Marque $marque
     *
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $em, Marque $marque): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin.marque.list');
        }

        return $this->render('admin/marque/edit.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete marque.
     *
     * @Route("/admin/marque/{id}/delete", name="admin.marque.delete", methods="DELETE", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Marque $marque
     *
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em, Marque $marque): Response
    {
        if ($this->isCsrfTokenValid('delete' . $marque->getId(), $request->request->get('_token'))) {
            $em->remove($marque);
            $em->flush();
        }

        return $this->redirectToRoute('admin.marque.list');
    }
}
