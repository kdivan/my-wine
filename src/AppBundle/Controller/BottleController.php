<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cellar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Bottle;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
     * @Template(":bottle:index.html.twig")
     */
    public function indexAction(Cellar $cellar)
    {
        $em = $this->getDoctrine()->getManager();
        $bottles = $em->getRepository('AppBundle:Bottle')->findBy(
            ['cellar' => $cellar],
            ['id' => 'ASC']
        );

        return array(
            'bottles' => $bottles,
            'cellar' => $cellar,
        );
    }

    /**
     * Creates a new Bottle entity.
     *
     * @Route("/new", name="bottle_new")
     * @Method({"GET", "POST"})
     * @Template(":bottle:new.html.twig")
     */
    public function newAction(Request $request, Cellar $cellar)
    {
        $error = null;
        $bottle = new Bottle();
        $em = $this->getDoctrine()->getManager();
        $cellar = $em->getRepository('AppBundle:Cellar')->find($cellar);
        $bottle->setCellar($cellar);
        $form = $this->createForm('AppBundle\Form\BottleType', $bottle)
            ->add('unit', IntegerType::class, array(
                'mapped' => false,
                'required' => true,
            ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $unit = $form->get('unit')->getData();
            if ($this->get('appbundle.cellar_manager')->hasEnoughStorage($cellar, $unit)) {
                for ($i = 0; $i < $unit; ++$i) {
                    $bottle = clone $bottle;
                    $em->persist($bottle);
                    $em->flush();
                }
                if ($unit > 1) {
                    return $this->redirectToRoute('cellar_show', array('id' => $cellar->getId()));
                } else {
                    return $this->redirectToRoute('bottle_show', array('cellar' => $cellar->getId(), 'id' => $bottle->getId()));
                }
            } else {
                $availableSpace = $this->get('appbundle.cellar_manager')->getAvailableSpace($cellar);
                $error = 'cellar.not_enough_space';
            }
        }

        return array(
            'bottle' => $bottle,
            'form' => $form->createView(),
            'cellar' => $cellar,
            'error' => $error,
            'availableSpace' => isset($availableSpace) ? $availableSpace : null,
        );
    }

    /**
     * Finds and displays a Bottle entity.
     *
     * @Route("/{id}", name="bottle_show")
     * @Method("GET")
     * @Template(":bottle:show.html.twig")
     */
    public function showAction(Bottle $bottle, Cellar $cellar)
    {
        $deleteForm = $this->createDeleteForm($bottle, $cellar);

        return array(
            'bottle' => $bottle,
            'delete_form' => $deleteForm->createView(),
            'cellar' => $cellar,
        );
    }

    /**
     * Displays a form to edit an existing Bottle entity.
     *
     * @Route("/{id}/edit", name="bottle_edit")
     * @Method({"GET", "POST"})
     * @Template(":bottle:edit.html.twig")
     */
    public function editAction(Request $request, Bottle $bottle, Cellar $cellar)
    {
        $deleteForm = $this->createDeleteForm($bottle, $cellar);
        if (strlen($bottle->getImageName()) > 0) {
            $bottleImagePath = $this->getParameter('bottle_image_path').$bottle->getImageName();
            if (file_exists($bottleImagePath)) {
                $bottle->setImageFile(new File($bottleImagePath));
            }
        }
        $editForm = $this->createForm('AppBundle\Form\BottleType', $bottle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bottle);
            $em->flush();

            return $this->redirectToRoute('bottle_show', array('cellar' => $cellar->getId(),  'id' => $bottle->getId()));
        }

        return array(
            'bottle' => $bottle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'cellar' => $cellar,
        );
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

        return $this->redirectToRoute('cellar_show', [
            'id' => $cellar->getId(), ]);
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
