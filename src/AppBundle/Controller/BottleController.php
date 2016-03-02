<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cellar;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Bottle;
use AppBundle\Form\BottleType;

/**
 * Bottle controller.
 *
 * @Route("/cellar/{cellarId}/bottle")
 */
class BottleController extends Controller
{
    /**
     * Lists all Bottle entities.
     *
     * @Route("/", name="bottle_index")
     * @Method("GET")
     */
    public function indexAction($cellarId)
    {
        $em = $this->getDoctrine()->getManager();

        $bottles = $em->getRepository('AppBundle:Bottle')->findAll();

        return $this->render('bottle/index.html.twig', array(
            'bottles' => $bottles,
            'cellarId' => $cellarId,
        ));
    }

    /**
     * Creates a new Bottle entity.
     *
     * @Route("/new", name="bottle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $cellarId)
    {
        $bottle = new Bottle();
        $em = $this->getDoctrine()->getManager();
        $cellar = $em->getRepository('AppBundle:Cellar')->find($cellarId);
        $bottle->setCellar($cellar);
        $form = $this->createForm('AppBundle\Form\BottleType', $bottle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($bottle);
            $em->flush();

            return $this->redirectToRoute('bottle_show', array('id' => $bottle->getId()));
        }

        return $this->render('bottle/new.html.twig', array(
            'bottle' => $bottle,
            'form' => $form->createView(),
            'cellarId' => $cellarId,
        ));
    }

    /**
     * Finds and displays a Bottle entity.
     *
     * @Route("/{id}", name="bottle_show")
     * @Method("GET")
     */
    public function showAction(Bottle $bottle, $cellarId)
    {
        $deleteForm = $this->createDeleteForm($bottle);

        return $this->render('bottle/show.html.twig', array(
            'bottle' => $bottle,
            'delete_form' => $deleteForm->createView(),
            'cellarId' => $cellarId,
        ));
    }

    /**
     * Displays a form to edit an existing Bottle entity.
     *
     * @Route("/{id}/edit", name="bottle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bottle $bottle, $cellarId)
    {
        $deleteForm = $this->createDeleteForm($bottle, $cellarId);
        $editForm = $this->createForm('AppBundle\Form\BottleType', $bottle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bottle);
            $em->flush();

            return $this->redirectToRoute('bottle_edit', array('id' => $bottle->getId()));
        }

        return $this->render('bottle/edit.html.twig', array(
            'bottle' => $bottle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'cellarId' => $cellarId,
        ));
    }

    /**
     * Deletes a Bottle entity.
     *
     * @Route("/{id}", name="bottle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bottle $bottle, $cellarId)
    {
        $form = $this->createDeleteForm($bottle, $cellarId);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bottle);
            $em->flush();
        }

        return $this->redirectToRoute('bottle_index', [$cellarId]);
    }

    /**
     * Creates a form to delete a Bottle entity.
     *
     * @param Bottle $bottle The Bottle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bottle $bottle, $cellarId)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bottle_delete', array('cellarId' => $cellarId, 'id' => $bottle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
