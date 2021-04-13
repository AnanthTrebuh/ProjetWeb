<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneralController extends AbstractController
{
    /**
     * @route(
     *     name="generale_utilisateur_determine"
     * )
     */
    /*determine si l'utilisateur est un visiteur enregistrer un admin ou un visiteur non enregistrer */
    public function determineAction(){
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneByidentifiant($user);

        /* $args=array(
        *     'user'=>$utilisateur
 ,      * );
        * return $this->render('tree_trunk/test.html.twig', $args);
        */
        /*test si ça fonctionne bien*/
        if($utilisateur = null){
            return 'null';
        }
        else if($utilisateur->getIsadmin())
        {
            return 'admin';
        }
        else
        {
            return 'visiteur';
        }
    }

    /**
     * @route ("/create-flash",
     *     name="general_create_flash")
     */
    public function createFlashAction():Response
    {
        $this->addFlash('info', 'Tout s\'est bien passé');
        $this->addFlash('info', 'et vraiment bien');

        return $this->redirectToRoute('genrale_display_flash');
    }

    /**
     * @route(
     *     "/general-flash",
     *     name="sandbox_display_flash"
     * )
     */
    public function dysplayFlashAction(): Response
    {
        return $this->render('Sandbox/dysplay_flash.html.twig');
    }
}
