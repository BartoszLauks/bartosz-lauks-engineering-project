<?php

namespace App\Controller;

use App\Repository\UserRepository;
use http\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TestController extends AbstractController
{
    #[Route('/test/email', name: 'test')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            //->from('bartoszlauks@gmail.com')
            ->from('test@test.pl')
            //->to('cruzonek@gmail.com')
            ->to('bartosz.lauks@interia.pl')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!');
        //->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/test')]
    public function testuser(Security $security, UserRepository $userRepository, Request $request)
    {
        dd($request);

    }
}
