<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
     * @Template(":cellar:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cellars = $em->getRepository('AppBundle:Cellar')->findBy(
            ['user' => $this->getUser(), ]
        );

        return array(
            'cellars' => $cellars,
        );
    }

    /**
     * Creates a new Cellar entity.
     *
     * @Route("/new", name="cellar_new")
     * @Method({"GET", "POST"})
     * @Template(":cellar:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $cellar = new Cellar();
        $cellar->setUser($this->getUser());
        $form = $this->createForm('AppBundle\Form\CellarType', $cellar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cellar);
            $em->flush();

            return $this->redirectToRoute('cellar_show', array('id' => $cellar->getId()));
        }

        return array(
            'cellar' => $cellar,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cellar entity.
     *
     * @Route("/{id}", name="cellar_show")
     * @Method("GET")
     * @Template(":cellar:show.html.twig")
     */
    public function showAction(Cellar $cellar)
    {
        $deleteForm = $this->createDeleteForm($cellar);
        $em = $this->getDoctrine()->getManager();
        $bottles = $em->getRepository('AppBundle:Bottle')->findBy(
            ['cellar' => $cellar],
            ['id' => 'ASC']
        );
        return array(
            'cellar' => $cellar,
            'bottles' => $bottles,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cellar entity.
     *
     * @Route("/{id}/edit", name="cellar_edit")
     * @Method({"GET", "POST"})
     * @Template(":cellar:edit.html.twig")
     */
    public function editAction(Request $request, Cellar $cellar)
    {
        $cellarImagePath = $this->getParameter('cellar_image_path').$cellar->getImageName();
        if (file_exists($cellarImagePath)) {
            $cellar->setImageFile(new File($cellarImagePath));
        }
        $deleteForm = $this->createDeleteForm($cellar);
        $editForm = $this->createForm('AppBundle\Form\CellarType', $cellar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cellar);
            $em->flush();

            return $this->redirectToRoute('cellar_index');
        }

        return array(
            'cellar' => $cellar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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
