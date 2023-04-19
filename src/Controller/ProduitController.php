<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit', name: 'produit_')]
class ProduitController extends AbstractController
{
    #[Route('/ajouter', name: 'ajouter')]
    public function nouveauProduit(EntityManagerInterface $entityManager, Request $request, ): Response
    {
        $produit = new Produit();
        $produitForm = $this->createForm(ProduitType::class, $produit);

        $produitForm->handleRequest($request);

        if($produitForm->isSubmitted() && $produitForm->isValid()){
            $entityManager->persist($produit);
            $entityManager->flush();
            $this->addFlash('succes', 'le produit a été ajouté');
            return $this->render('home/index.html.twig', [
                'controller_name' => 'ProduiteController'
            ]);

        }

        return $this->render('produit/ajouter.html.twig', [
            'controller_name' => 'ProduitController',
            'produitForm' => $produitForm->createView(),
        ]);
    }
    #[Route('/details/{id}', name: 'details')]
    public function detailProduit(ProduitRepository $produitRepository, $id) : Response
    {
        $produit = $produitRepository->findOneBy(['id' => $id]);
        return $this->render('produit/details.html.twig', [
            'controller_name' => 'ProduitController',
            'produit' => $produit
        ]);
    }
}
