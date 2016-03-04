<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BottleType;
use AppBundle\Form\BottleTypeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * BottleType controller.
 *
 * @Route("/bottletype")
 */
class BottleTypeController extends Controller
{
    /**
     * Lists all BottleType entities.
     *
     * @Route("/", name="bottletype_index")
     * @Method("GET")
     * @Template(":bottletype:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bottleTypes = $em->getRepository('AppBundle:BottleType')->findAll();

        return array(
            'bottleTypes' => $bottleTypes,
        );
    }

    /**
     * Creates a new BottleType entity.
     *
     * @Route("/new", name="bottletype_new")
     * @Method({"GET", "POST"})
     * @Template(":bottletype:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $bottleType = new BottleType();
        $form = $this->createForm('AppBundle\Form\BottleTypeType', $bottleType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bottleType);
            $em->flush();

            return $this->redirectToRoute('bottletype_show', array('id' => $bottleType->getId()));
        }

        return array(
            'bottleType' => $bottleType,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a BottleType entity.
     *
     * @Route("/{id}", name="bottletype_show")
     * @Method("GET")
     * @Template(":bottletype:show.html.twig")
     */
    public function showAction(BottleType $bottleType)
    {
        $deleteForm = $this->createDeleteForm($bottleType);

        return array(
            'bottleType' => $bottleType,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BottleType entity.
     *
     * @Route("/{id}/edit", name="bottletype_edit")
     * @Method({"GET", "POST"})
     * @Template(":bottletype:edit.html.twig")
     */
    public function editAction(Request $request, BottleType $bottleType)
    {
        $deleteForm = $this->createDeleteForm($bottleType);
        $editForm = $this->createForm('AppBundle\Form\BottleTypeType', $bottleType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bottleType);
            $em->flush();

            return $this->redirectToRoute('bottletype_edit', array('id' => $bottleType->getId()));
        }

        return array(
            'bottleType' => $bottleType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BottleType entity.
     *
     * @Route("/{id}", name="bottletype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BottleType $bottleType)
    {
        $form = $this->createDeleteForm($bottleType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bottleType);
            $em->flush();
        }

        return $this->redirectToRoute('bottletype_index');
    }

    /**
     * Creates a form to delete a BottleType entity.
     *
     * @param BottleType $bottleType The BottleType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BottleType $bottleType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bottletype_delete', array('id' => $bottleType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
