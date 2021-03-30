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
    public function index(): Response
    {
        return $this->render('tree_trunk/index.html.twig', [
            'controller_name' => 'TreeTrunkController',
        ]);
    }
}
