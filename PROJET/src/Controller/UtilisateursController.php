<?php

namespace App\Controller;

use App\Controller\GeneralController;
use App\Entity\TreeTrunk;
use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\reverse;

/**
 * Class UtilisateursController
 * @package App\Controller
 * @Route("/utilisateur")
 */
class UtilisateursController extends AbstractController
{
    /**
     * @Route("/list", name="utilisateurs_list")
     */
    public function listUserAction(): Response
    {
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if($utilisateur == null || !$utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas acces à cette page');
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
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if($utilisateur != null)
        {
            throw new NotFoundHttpException('Vous n\'avez pas acces à cette page');
        }
        return $this->render('utilisateurs/connexion.html.twig');
    }

    /**
     * @route(
     *     "/creation_compte",
     *     name="utilisateur_creation_compte"
     * )
     * @param Request $request
     * @param reverser $rev
     * @return Response
     */
    public function creationAction(Request $request, reverse $rev):Response
    {

        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if($utilisateur != null)
        {
            throw new NotFoundHttpException('Vous n\'avez pas acces à cette page');
        }
        $em = $this->getDoctrine()->getManager();
        $utilisateur = new Utilisateurs();
        $utilisateur->setIsadmin(false);
        $form = $this->createFormBuilder($utilisateur)
                ->add('identifiant', TextType::class)
                ->add('motdepasse',PasswordType::class)
                ->add('nom',TextType::class)
                ->add('prenom',TextType::class)
                ->add('anniversaire',BirthdayType::class)
                ->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $mdp = $utilisateur->getMotdepasse();
            $utilisateur->setMotdepasse(sha1($mdp));

            $this->addFlash('success',$rev->reverse_message('Vous etes bien inscris.'));
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->render('utilisateurs/creation_compte.html.twig', [
            'formUtilisateur' => $form->createView()
        ]);

    }
    /**
     * @route(
     *     "/suppr/{id}",
     *     name="utilisateur_supprime"
     * )
     */
    public function supprimeAction($id)
    {
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if(!$utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }
        if($utilisateur->getId() == $id)
        {
            $this->addFlash('failure', 'Vous ne pouvez pas vous supprimer');
        }
        else {
            $em = $this->getDoctrine()->getManager();
            $utilisateurRepository = $em->getRepository('App:Utilisateurs');
            $utilisateur = $utilisateurRepository->find($id);
            $em->remove($utilisateur);
            $em->flush();

        }
        return $this->redirectToRoute('panier_suppr_user_panier', ['id' => $id]);
    }

    /**
     * @route(
     *      "/profil",
     *     name="utilisateur_profil"
     *     )
     */
    public function profilAction(Request $request) {
        $user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));

        if(!$utilisateur || $utilisateur->getIsadmin())
        {
            throw new NotFoundHttpException('Vous n\'avez pas avoir acces à cette page');
        }

        $form = $this->createFormBuilder($utilisateur)
            ->add('identifiant', TextType::class)
            ->add('motdepasse',PasswordType::class)
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('anniversaire',BirthdayType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $mdp = $utilisateur->getMotdepasse();
            $utilisateur->setMotdepasse(sha1($mdp));

            $utilisateur2 = $utilisateur;
            $em->remove($utilisateur);

            $this->addFlash('success','Modification effectué.');
            $em->persist($utilisateur2);
            $em->flush();

            return $this->redirectToRoute('treeTrunk_list');
        }

        return $this->render('utilisateurs/profil.html.twig', [
            'form' => $form->createView(),
            'user' => $utilisateur
        ]);
    }

    /**
     * @route(
     *     "/deconnexion",
     *     name="utilisateur_deconnexion"
     *     )
     */
    public function deconnexionAction()
    {$user = $this->getParameter('user');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateurs');
        $utilisateur = $utilisateurRepository->findOneBy(array('identifiant' => $user));
        if($utilisateur == null)
        {
            throw new NotFoundHttpException('Vous n\'avez pas acces à cette page');
        }
        $this->addFlash('success','Vous êtes bien deconnecté');
        return $this->redirectToRoute('accueil');
    }
}
/*
 * Nathan Hubert
 * Valentin Lescorbie
 */