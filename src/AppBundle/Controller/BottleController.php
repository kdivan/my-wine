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
 * @Route("/cellar/{cellar}/bottle")
 */
class BottleController extends Controller
{
    /**
     * Lists all Bottle entities.
     *
     * @Route("/", name="bottle_index")
     * @Method("GET")
     */
    public function indexAction(Cellar $cellar)
    {
        dump($cellar);
        $em = $this->getDoctrine()->getManager();
        $bottles = $em->getRepository('AppBundle:Bottle')->findBy(
            ['cellar' => $cellar],
            ['id' => 'ASC']
        );

        dump($bottles);
        return $this->render('bottle/index.html.twig', array(
            'bottles' => $bottles,
            'cellar' => $cellar,
        ));
    }

    /**
     * Creates a new Bottle entity.
     *
     * @Route("/new", name="bottle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Cellar $cellar)
    {
        dump($cellar);
        $bottle = new Bottle();
        $em = $this->getDoctrine()->getManager();
        $cellar = $em->getRepository('AppBundle:Cellar')->find($cellar);
        $bottle->setCellar($cellar);
        dump($em->getRepository('AppBundle:BottleType')->findAll());
        $form = $this->createForm('AppBundle\Form\BottleType', $bottle,
            array('bottleTypes' => $em->getRepository('AppBundle:BottleType')->findAll()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($bottle);
            $em->flush();

            return $this->redirectToRoute('bottle_show', array('cellar' => $cellar->getId(), 'id' => $bottle->getId()));
        }

        return $this->render('bottle/new.html.twig', array(
            'bottle' => $bottle,
            'form' => $form->createView(),
            'cellar' => $cellar,
        ));
    }

    /**
     * Finds and displays a Bottle entity.
     *
     * @Route("/{id}", name="bottle_show")
     * @Method("GET")
     */
    public function showAction(Bottle $bottle, Cellar $cellar)
    {
        $deleteForm = $this->createDeleteForm($bottle, $cellar);

        return $this->render('bottle/show.html.twig', array(
            'bottle' => $bottle,
            'delete_form' => $deleteForm->createView(),
            'cellar' => $cellar,
        ));
    }

    /**
     * Displays a form to edit an existing Bottle entity.
     *
     * @Route("/{id}/edit", name="bottle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bottle $bottle, Cellar $cellar)
    {
        $deleteForm = $this->createDeleteForm($bottle, $cellar);
        $editForm = $this->createForm('AppBundle\Form\BottleType', $bottle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bottle);
            $em->flush();

            return $this->redirectToRoute('bottle_edit', array('cellar' => $cellar->getId(),  'id' => $bottle->getId()));
        }

        return $this->render('bottle/edit.html.twig', array(
            'bottle' => $bottle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'cellar' => $cellar,
        ));
    }

    /**
     * Deletes a Bottle entity.
     *
     * @Route("/{id}", name="bottle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bottle $bottle, Cellar $cellar)
    {
        $form = $this->createDeleteForm($bottle, $cellar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bottle);
            $em->flush();
        }

        return $this->redirectToRoute('bottle_index', [$cellar]);
    }

    /**
     * Creates a form to delete a Bottle entity.
     *
     * @param Bottle $bottle The Bottle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bottle $bottle, Cellar $cellar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bottle_delete', array('cellar' => $cellar->getId(), 'id' => $bottle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
