<?php

namespace App\EventSubscriber;

use App\Entity\SpecialistComment;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $security;
    private $userRepository;

    public function __construct(
        Security $security,
        UserRepository $userRepository
    ) {
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            //BeforeEntityPersistedEvent::class => ['setSpecialistUser'],
        ];
    }

    public function setSpecialistUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof SpecialistComment) {
            $entity->setUser($this->userRepository->find($this->security->getUser()));
        }
    }
}