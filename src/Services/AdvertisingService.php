<?php

namespace App\Services;

use App\Repository\AdvertisingRepository;

class AdvertisingService
{
    private $advertisingRepository;

    public function __construct(
        AdvertisingRepository $advertisingRepository)
    {
        $this->advertisingRepository = $advertisingRepository;
    }

    public function getAdvertisingPath(): string
    {
        $ads = $this->advertisingRepository->getActiveAdvertising();
        if (empty($ads))
        {
            return 'default.png';
        }
        $random = rand(0,count($ads)-1);
        return $ads[$random]->getFile();
    }
    public function getAdvertisingUrl()
    {
        $ads = $this->advertisingRepository->getActiveAdvertising();
        if (empty($ads))
        {
            return '';
        }
        $random = rand(0,count($ads)-1);
        return $ads[$random]->getUrl();
    }

}