<?php

namespace App\Controller;

use App\Entity\TestBrand;
use App\Form\NewsType;
use App\Form\SelectCarComponetsType;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use App\Repository\TestBrandRepository;
use App\Repository\TestGenerationRepository;
use App\Repository\TestModelRepository;
use App\Repository\UserRepository;
use http\Cookie;
use phpDocumentor\Reflection\Types\Integer;
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
    private $brandRepository;
    private $modelRepository;
    private $testBrandRepository;
    private $testModelRepository;
    private $testGenerationRepository;


    public function __construct
    (
        MailerInterface $mailer,
        Security $security,
        UserRepository $userRepository,
        FormFactoryInterface $formFactory,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        //TestBrandRepository $testBrandRepository,
        //TestModelRepository $testModelRepository,
        //TestGenerationRepository $testGenerationRepository,
    ) {
        $this->mailer = $mailer;
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->formFactory = $formFactory;
        $this->brandRepository = $brandRepository;
        $this->modelRepository = $modelRepository;
        //$this->testBrandRepository = $testBrandRepository;
        //$this->testModelRepository = $testModelRepository;
        //$this->testGenerationRepository = $testGenerationRepository;
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

    #[Route('/orm')]
    public function ormtest()
    {
        //dd($this->testModelRepository->findOneBy(['id' => '1'])->getGeneration());
        //dd($this->modelRepository->findOneBy(['id' => '1'])->getGenerations());

    }
}