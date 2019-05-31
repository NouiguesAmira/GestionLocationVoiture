<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Form\Admin\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class VoitureController extends AbstractController
{
    /**
     * Lists all voitures entities.
     *
     * @Route("/",
     *     name="voiture.list",
     *     methods="GET",
     * )
     *
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function list(EntityManagerInterface $em): Response
    {
        $voitures = $em->getRepository(Voiture::class)->findAll();

        return $this->render('voiture/list.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show_voiture")
     */
    public function show($id, Voiture $voiture, Request $request, ObjectManager $manager)
    {


        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setClient($this->getUser())
                ->setVoiture($voiture)
                ->setDateDebutReservation(new \DateTime())
                ->setLieu('hellow')
                ->setNbJours(3);
            $manager->persist($reservation);
            $manager->flush();

            return $this->redirectToRoute('show_voiture', [
                'id' => $id
            ]);
        }

        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET"})
     */
    public function contact(): Response
    {
        return $this->render('voiture/contact.html.twig');
    }
}
