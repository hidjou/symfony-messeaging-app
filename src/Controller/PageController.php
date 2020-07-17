<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twilio\Rest\Client as TwilioClient;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;

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

        // Get current user
        $user = $this->getUser();
            
        // Attach user id to message
        $message->setUserId($user->getId());

        // TODO: Validate data (text not empty, recipient not empty and numerical)

        // TODO: Trim number, remove white spaces, ?? replace '+' with 00 ??
        

        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $formData = $form->getData();

            // Accessing .env vars with '$_ENV()' as I couldnt find the equivalent in Symfony quickly haha
            $twilio = new TwilioClient($_ENV['TWILIO_SID'], $_ENV['TWILIO_AUTH_TOKEN']);

            // TODO: Handle errors
            $newMessage = $twilio->messages->create(
                // the number you'd like to send the message to
                // +447591339388
                $message->getRecipient(),
                [
                    // A Twilio phone number you purchased at twilio.com/console
                    // TODO: Get verified numbers from DB
                    "from" => "+17205839384",
                    // the body of the text message you"d like to send
                    "body" => $message->getText()
                ]
            );

            $message->setSid($newMessage->sid);
            $message->setStatus($newMessage->status);

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

    /**
     * Messages page where user can see the messages they sent
     * @Route("/messages", name="messages")
     */
    public function messages(MessageRepository $messageRepository) : Response
    {
        $user = $this->getUser();

        $messages = $messageRepository->findBy(
            ['user_id' => $user->getId()],
            ['created_at' => 'DESC']
        );

        

        // TODO: Get user messages
        return $this->render('page/messages.html.twig', [
            'messages' => $messages
        ]);
    }
}
