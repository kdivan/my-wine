<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Bottle;
use AppBundle\Form\BottleType;

/**
 * Bottle controller.
 *
 * @Route("/bottle")
 */
class BottleController extends Controller
{
    /**
     * Lists all Bottle entities.
     *
     * @Route("/", name="bottle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bottles = $em->getRepository('AppBundle:Bottle')->findAll();

        return $this->render('bottle/index.html.twig', array(
            'bottles' => $bottles,
        ));
    }

    /**
     * Creates a new Bottle entity.
     *
     * @Route("/new", name="bottle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bottle = new Bottle();
        $form = $this->createForm('AppBundle\Form\BottleType', $bottle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bottle);
            $em->flush();

            return $this->redirectToRoute('bottle_show', array('id' => $bottle->getId()));
        }

        return $this->render('bottle/new.html.twig', array(
            'bottle' => $bottle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bottle entity.
     *
     * @Route("/{id}", name="bottle_show")
     * @Method("GET")
     */
    public function showAction(Bottle $bottle)
    {
        $deleteForm = $this->createDeleteForm($bottle);

        return $this->render('bottle/show.html.twig', array(
            'bottle' => $bottle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Bottle entity.
     *
     * @Route("/{id}/edit", name="bottle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bottle $bottle)
    {
        $deleteForm = $this->createDeleteForm($bottle);
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
        ));
    }

    /**
     * Deletes a Bottle entity.
     *
     * @Route("/{id}", name="bottle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bottle $bottle)
    {
        $form = $this->createDeleteForm($bottle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bottle);
            $em->flush();
        }

        return $this->redirectToRoute('bottle_index');
    }

    /**
     * Creates a form to delete a Bottle entity.
     *
     * @param Bottle $bottle The Bottle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bottle $bottle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bottle_delete', array('id' => $bottle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
