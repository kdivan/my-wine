<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CapacityType;
use AppBundle\Form\CapacityTypeType;

/**
 * CapacityType controller.
 *
 * @Route("/capacitytype")
 */
class CapacityTypeController extends Controller
{
    /**
     * Lists all CapacityType entities.
     *
     * @Route("/", name="capacitytype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $capacityTypes = $em->getRepository('AppBundle:CapacityType')->findAll();

        return $this->render('capacitytype/index.html.twig', array(
            'capacityTypes' => $capacityTypes,
        ));
    }

    /**
     * Creates a new CapacityType entity.
     *
     * @Route("/new", name="capacitytype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $capacityType = new CapacityType();
        $form = $this->createForm('AppBundle\Form\CapacityTypeType', $capacityType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($capacityType);
            $em->flush();

            return $this->redirectToRoute('capacitytype_show', array('id' => $capacityType->getId()));
        }

        return $this->render('capacitytype/new.html.twig', array(
            'capacityType' => $capacityType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CapacityType entity.
     *
     * @Route("/{id}", name="capacitytype_show")
     * @Method("GET")
     */
    public function showAction(CapacityType $capacityType)
    {
        $deleteForm = $this->createDeleteForm($capacityType);

        return $this->render('capacitytype/show.html.twig', array(
            'capacityType' => $capacityType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CapacityType entity.
     *
     * @Route("/{id}/edit", name="capacitytype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CapacityType $capacityType)
    {
        $deleteForm = $this->createDeleteForm($capacityType);
        $editForm = $this->createForm('AppBundle\Form\CapacityTypeType', $capacityType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($capacityType);
            $em->flush();

            return $this->redirectToRoute('capacitytype_edit', array('id' => $capacityType->getId()));
        }

        return $this->render('capacitytype/edit.html.twig', array(
            'capacityType' => $capacityType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CapacityType entity.
     *
     * @Route("/{id}", name="capacitytype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CapacityType $capacityType)
    {
        $form = $this->createDeleteForm($capacityType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($capacityType);
            $em->flush();
        }

        return $this->redirectToRoute('capacitytype_index');
    }

    /**
     * Creates a form to delete a CapacityType entity.
     *
     * @param CapacityType $capacityType The CapacityType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CapacityType $capacityType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('capacitytype_delete', array('id' => $capacityType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
