<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Client;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Voiture;
use App\Repository\ClientRepository;
use App\Repository\VoitureRepository;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/facture", name="facture", methods={"GET"})
     */
    public function facture(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/facture.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $em, ClientRepository $cr, VoitureRepository $vr): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        $idc = $request->query->get('idc');
        $idv = $request->query->get('idv');


        if ($form->isSubmitted() && $form->isValid()) {
            $client =  $cr->find($idc);
            $reservation->setClient($client);
            $voiture = $vr->find($idv);
            $reservation->setVoiture($voiture);
            $em->persist($reservation);
            //if ( $reservation->dateFinReservation - $reservation->dateDebutReservation >0 )
            /// {
            ///  if($reservation->dateDebutReservation >= $reservation->dateFinReservation;$i++)
            //// }
            //$voiture->setDisponible(0);
            //    $em->persist($voiture);
            $em->flush();
            $pt = $reservation->nbJours * $voiture->prix;
            return $this->render(
                'reservation/facture.html.twig',
                [
                    'v' => $voiture,
                    'c' => $client,
                    'r' => $reservation,
                    'pt' => $pt
                ]
            );
        }


        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(), "idv" => $idv, "client" => $idc,
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index', [
                'id' => $reservation->getId(),
            ]);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }
}
