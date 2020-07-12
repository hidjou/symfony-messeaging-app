<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Message;
use App\Form\MessageType;

/**
 * @Route("/", name="page.")
 */
class PageController extends AbstractController
{
    /**
     * Serve the home page with the form for the message
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
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

        

        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $formData = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('page.success');
        }

        return $this->render('page/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Show success message (pun intended)
     * @Route("/success", name="success")
     */
    public function success(): Response
    {
        return $this->render('page/success.html.twig');
    }
}
