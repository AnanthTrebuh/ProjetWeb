<?php

namespace App\Controller;

use App\Entity\TreeTrunk;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TreeTrunkType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class TreeTrunkController extends AbstractController
{


    /**
     * @Route("/ajout", name="treeTrunk_ajout")
     */
    public function ajoutAction(Request $request)
    {
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur->getIsadmin() || $utilisateur == null)
        {
            throw new NotFoundHttpException('Vous n\'avez pas acces à cette page');
        }
        $treeTrunk = new TreeTrunk();

        $form = $this->createFormBuilder($treeTrunk)
                     ->add('name')
                     ->add('quantite')
                     ->add('prix')
                     ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($treeTrunk);
            $em->flush();

            $this->addFlash('success','Ajout effectué.');
            return $this->redirectToRoute('accueil');
        }

        return $this->render('tree_trunk/ajout.html.twig', [
            'formTreeTrunk' => $form->createView()
        ]);
    }




    /**
     * @route(
     *     "tree_trunk/list",
     *      name="treeTrunk_list"
     *     )
     */
    public function listAction(Request $request){
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur || $utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }

        $treeTrunkRepository = $em->getRepository('App:TreeTrunk');
        $treeTrunks = $treeTrunkRepository->findAll();


        $args = array(
            'treeTrunks' => $treeTrunks
        );

        return $this->render("tree_trunk/list.html.twig", $args);

    }

}
/*
 * Nathan Hubert
 * Valentin Lescorbie
 */