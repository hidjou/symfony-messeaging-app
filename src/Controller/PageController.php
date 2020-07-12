<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Message;

/**
 * @Route("/", name="page.")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $message = new Message();
        
        // // Create a message and persist it (testing)
        // $message->setText('Hi Ahmed!');
        // $message->setUserId(1);
        // $message->setRecipient('00447459188428');
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($message);
        // $em->flush();

        // TODO: Validate data (text not empty, recipient not empty and numerical)

        // TODO: Trim number, remove white spaces, replace '+' with 00

        

        // $form = $this->createForm(MessageType::class, $message);

        return $this->render('page/index.html.twig');
    }
}
