<?php

namespace App\Controller;

use App\Services\AdvertisingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdvertisingController extends AbstractController
{
    private AdvertisingService $advertisingService;

    public function __construct(
        AdvertisingService $advertisingService)
    {
        $this->advertisingService = $advertisingService;
    }

    public function index(): Response
    {
        return $this->render("/advertising/Ads.html.twig",[
            'path' => $this->advertisingService->getAdvertisingPath(),
            'url' => $this->advertisingService->getAdvertisingUrl()
        ]);
    }
}
