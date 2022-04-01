<?php

namespace App\Controller;

use App\Entity\Condo;
use App\Form\CondoType;
use App\Repository\CondoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/condo')]
class CondoController extends AbstractController
{
    #[Route('/', name: 'app_condo_index', methods: ['GET'])]
    public function index(CondoRepository $condoRepository): Response
    {
        return $this->render('condo/index.html.twig', [
            'condos' => $condoRepository->findAll(),
        ]);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/new', name: 'app_condo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CondoRepository $condoRepository): Response
    {
        $condo = new Condo();

        if ($user = $this->getUser()) {
            $condo->addUser($user);
        }

        $form = $this->createForm(CondoType::class, $condo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $condoRepository->add($condo);
            return $this->redirectToRoute('app_condo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('condo/new.html.twig', [
            'condo' => $condo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_condo_show', methods: ['GET'])]
    public function show(Condo $condo): Response
    {
        echo $condo;
        return $this->render('condo/show.html.twig', [
            'condo' => $condo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_condo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Condo $condo, CondoRepository $condoRepository): Response
    {
        $form = $this->createForm(CondoType::class, $condo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $condoRepository->add($condo);
            return $this->redirectToRoute('app_condo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('condo/edit.html.twig', [
            'condo' => $condo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_condo_delete', methods: ['POST'])]
    public function delete(Request $request, Condo $condo, CondoRepository $condoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$condo->getId(), $request->request->get('_token'))) {
            $condoRepository->remove($condo);
        }

        return $this->redirectToRoute('app_condo_index', [], Response::HTTP_SEE_OTHER);
    }
}
