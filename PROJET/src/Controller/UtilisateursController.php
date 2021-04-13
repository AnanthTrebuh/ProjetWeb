<?php

namespace App\Controller;

use App\Controller\GeneralController;
use App\Entity\TreeTrunk;
use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UtilisateursController extends AbstractController
{
    /**
     * @Route("/utilisateurs/list", name="utilisateurs_list")
     */
    public function listAction(): Response
    {
        $user = $this->determineAction(); /* remplacer par getParameter('user'); */
        if($user != 'admin')
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }

        $em = $this->getDoctrine()->getManager();
        $utilisateursRepository = $em->getRepository("App:Utilisateurs");
        $utilisateurs = $utilisateursRepository->findAll();

        $args = array(
            'utilisateurs' => $utilisateurs
        );
        return $this->render('utilisateurs/list.html.twig', $args);
    }

    /**
     * @route("/connexion", name="utilisateur_connexion")
     */
    public function connexionAction()
    {
        return $this->render('utilisateurs/connexion.html.twig');
    }

    /**
     * @route(
     *     "/utilisateur/creation_compte",
     *     name="utilisateur_creation_compte"
     * )
     */
    public function creationAction(Request $request):Response
    {
        $user = $this->determineAction(); /* remplacer par getParameter('user'); */
        if($user != 'null')
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }
        $em = $this->getDoctrine()->getManager();
        $utilisateur = new Utilisateurs();

        $form = $this->createFormBuilder($utilisateur)
                ->add('identifiant')
                ->add('motdepasse')
                ->add('nom')
                ->add('prenom')
                ->add('anniversaire')
                ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('acceuil');
        }

        return $this->render('utilisateurs/creation_compte.html.twig', [
            'formUtilisateur' => $form->createView()
        ]);

    }

    /**
     * @route(
     *     "utilisateur/suppr/{id}",
     *     name="utilisateur_supprime"
     * )
     */
    public function supprimeAction($id)
    {
        $user = $this->determineAction(); /* remplacer par getParameter('user'); */
        if($user != 'admin')
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->find($id);

        $em->remove($utilisateur);

        return $this->render('utilisateurs/list.html.twig');
    }

    /**
     * @route(
     *     "/deconnexion",
     *     name="utilisateur_deconnexion"
     *     )
     */
    public function deconnexionAction()
    {

    }

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
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));

        /* $args=array(
        *     'user'=>$utilisateur
 ,      * );
        * return $this->render('tree_trunk/test.html.twig', $args);
        */
        /*test si ça fonctionne bien*/
        if(!$utilisateur){
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
}
