<?php

namespace App\Controller;

use App\Form\NewsType;
use App\Form\SelectCarComponetsType;
use App\Repository\UserRepository;
use http\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/test')]
class TestController extends AbstractController
{
    private $mailer;
    private $security;
    private $userRepository;
    private $formFactory;

    public function __construct
    (
        MailerInterface $mailer,
        Security $security,
        UserRepository $userRepository,
        FormFactoryInterface $formFactory
    ) {
        $this->mailer = $mailer;
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->formFactory = $formFactory;
    }

    #[Route('/email', name: 'test')]
    public function index(): Response
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

        $this->mailer->send($email);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('')]
    public function testuser(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        dd($request);

    }
    #[Route('/remember')]
    public function testuserremeber(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_REMEMBERED');
        dd($request);
    }
    #[Route('/form')]
    public function testForm(Request $request)
    {
        $form = $this->formFactory->create(SelectCarComponetsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $this->render('test/index.html.twig');
        }

        return $this->render('test/test.html.twig',['form' => $form->createView()]);
    }
}
