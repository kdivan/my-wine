<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Cellar;
use AppBundle\Form\CellarType;

/**
 * Cellar controller.
 *
 * @Route("/cellar")
 */
class CellarController extends Controller
{
    /**
     * Lists all Cellar entities.
     *
     * @Route("/", name="cellar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cellars = $em->getRepository('AppBundle:Cellar')->findAll();

        return $this->render('cellar/index.html.twig', array(
            'cellars' => $cellars,
        ));
    }

    /**
     * Creates a new Cellar entity.
     *
     * @Route("/new", name="cellar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cellar = new Cellar();
        $form = $this->createForm('AppBundle\Form\CellarType', $cellar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cellar);
            $em->flush();

            return $this->redirectToRoute('cellar_show', array('id' => $cellar->getId()));
        }

        return $this->render('cellar/new.html.twig', array(
            'cellar' => $cellar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cellar entity.
     *
     * @Route("/{id}", name="cellar_show")
     * @Method("GET")
     */
    public function showAction(Cellar $cellar)
    {
        $deleteForm = $this->createDeleteForm($cellar);

       // $allBottle = $this->findAllBottlesByCellar($cellar->getId());

        return $this->render('cellar/show.html.twig', array(
            'cellar' => $cellar,
            'delete_form' => $deleteForm->createView(),
            'bottles' => $this->getDoctrine()->getRepository('AppBundle:Cellar')->findByCellar($cellar->getId()),
        ));
    }

    /**
     * Displays a form to edit an existing Cellar entity.
     *
     * @Route("/{id}/edit", name="cellar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cellar $cellar)
    {
        $deleteForm = $this->createDeleteForm($cellar);
        $editForm = $this->createForm('AppBundle\Form\CellarType', $cellar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cellar);
            $em->flush();

            return $this->redirectToRoute('cellar_edit', array('id' => $cellar->getId()));
        }

        return $this->render('cellar/edit.html.twig', array(
            'cellar' => $cellar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cellar entity.
     *
     * @Route("/{id}", name="cellar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cellar $cellar)
    {
        $form = $this->createDeleteForm($cellar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cellar);
            $em->flush();
        }

        return $this->redirectToRoute('cellar_index');
    }

    /**
     * Creates a form to delete a Cellar entity.
     *
     * @param Cellar $cellar The Cellar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cellar $cellar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cellar_delete', array('id' => $cellar->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
