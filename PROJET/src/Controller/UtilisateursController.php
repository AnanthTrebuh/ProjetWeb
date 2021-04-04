<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateursController extends AbstractController
{
    /**
     * @Route("/utilisateurs/list", name="utilisateurs")
     */
    public function listAction(): Response
    {
        return $this->render('utilisateurs/index.html.twig');
    }

    /**
     * @route(
     *     "/utilisateur/creation_compte",
     *     name="utilisateur_creation_compte"
     * )
     */
    public function creationAction():Response
    {

    }
}
