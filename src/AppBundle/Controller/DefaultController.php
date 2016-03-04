<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Model\Contact;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     * @Template(":default:blog.html.twig")
     */
    public function blogAction(Request $request)
    {
        $url = $this->generateUrl('post', [
            'year'  => '2015',
            'month' => '03',
            'day'   => '21',
            'title' => 'test',
        ]);

        dump($this->getUser());

        /*$post = new Post();
        $post->setTitle("Titre du post");
        $post->setBody("TEstsestset");
        $post->setIsPublished(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        /*$post->setTitle("retest");
        $em->persist($post);
        $em->flush();

        $em->remove($post);
        $em->flush();*/

        return [
            'url'   => $url,
            'posts' => $this->getDoctrine()->getRepository('AppBundle:Post')->findAllOrderByCreatedAt(),
        ];
    }

    /**
     * @Route(
     *     "/blog/{year}/{month}/{day}/{title}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_format": "html|rss",
     *         "year": "\d+",
     *          "month": "\d+",
     *          "day": "\d+"
     *     }
     *  , name="post")
     */
    public function postAction(Request $request, $year, $month, $day, $title)
    {
        // replace this example code with whatever you need
        return $this->render('default/post.html.twig', [
            'year'  => $year,
            'month' => $month,
            'day'   => $day,
            'title' => $title,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @Template(":default:contact.html.twig")
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form    = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('app.mailer')->sendContactMessage($form->getData());

            return $this->redirect('/contact');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/admin", name="admin_panel")
     * @Template(":default:admin.html.twig")
     */
    public function adminAction(Request $request)
    {
        return array();
    }
}
