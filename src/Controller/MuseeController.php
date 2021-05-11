<?php

namespace App\Controller;

use App\Entity\Musee;
use App\Form\MuseeType;
use App\Repository\MuseeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class MuseeController extends AbstractController
{
    #[Route('/', name: 'musee_index', methods: ['GET'])]
    public function index(MuseeRepository $museeRepository): Response
    {
        return $this->render('musee/index.html.twig', [
            'musees' => $museeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'musee_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $musee = new Musee();
        $form = $this->createForm(MuseeType::class, $musee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($musee);
            $entityManager->flush();

            return $this->redirectToRoute('musee_index');
        }

        return $this->render('musee/new.html.twig', [
            'musee' => $musee,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'musee_show', methods: ['GET'])]
    public function show(Musee $musee): Response
    {
        return $this->render('musee/show.html.twig', [
            'musee' => $musee,
        ]);
    }

    #[Route('/{id}/edit', name: 'musee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Musee $musee): Response
    {
        $form = $this->createForm(MuseeType::class, $musee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('musee_index');
        }

        return $this->render('musee/edit.html.twig', [
            'musee' => $musee,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'musee_delete', methods: ['POST'])]
    public function delete(Request $request, Musee $musee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$musee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($musee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('musee_index');
    }
}
