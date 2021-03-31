<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TreeTrunkType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class TreeTrunkController extends AbstractController
{
    /**
     * @Route("/tree/trunk", name="tree_trunk")
     */
    public function listAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $treeTrunkRepository = $em->getRepository('App:TreeTrunk');
        $treeTrunks = $treeTrunkRepository->findAll();
        $args = array(
            'treeTrunk' => $treeTrunks
        );
        return $this->render('tree_trunk/index.html.twig', $args);
    }
    /**
     * @Route("/accueil", name = "accueil")
     */
    public function ActionAccueil() : Reponse
    {
        return $this->render("acceuil.html.twig");
    }

}
