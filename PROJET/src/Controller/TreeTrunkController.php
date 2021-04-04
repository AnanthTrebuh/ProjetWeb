<?php

namespace App\Controller;

use App\Entity\TreeTrunk;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TreeTrunkType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class TreeTrunkController extends AbstractController
{
    /**
     * @Route("/", name="acceuil")
     */
    public function AcceuilAction() : Response
    {
        return $this->render('acceuil.html.twig');
    }

    /**
     * @Route("/test", name="test")
     */
    public function ActionTest() : Response
    {
        return $this->render('tree_trunk/test.html.twig');
    }

    /**
     * @Route("/ajout", name="treeTrunk_ajout")
     */
    public function ajoutAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
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

            $this->addFlash('info', 'ajout ok');
            return $this->redirectToRoute('treeTrunk_list');
        }

        return $this->render('tree_trunk/ajout.html.twig', [
            'formTreeTrunk' => $form->createView()
        ]);
    }

    /**
     * @Route("/list", name="treeTrunk_list")
     */
    public function listAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $treeTrunkRepository = $em->getRepository('App:TreeTrunk');
        $treeTrunks = $treeTrunkRepository->findAll();

        $args = array(
            'treeTrunks' => $treeTrunks
        );

        return $this->render('tree_trunk/list.html.twig', $args);
    }

    /**
     * @Route("/view/{id}", name="treeTrunk_view")
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $treeTrunkRepository = $em->getRepository('App:TreeTrunk');
        $treeTrunk = $treeTrunkRepository->find($id);

        $args = array(
            'treeTrunk' => $treeTrunk
        );

        return $this->render('tree_trunk/list.html.twig', $args);
    }
}
