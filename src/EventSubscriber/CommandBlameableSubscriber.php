<?php

namespace Kikwik\CommandBlameableBundle\EventSubscriber;

use Gedmo\Blameable\BlameableListener;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandBlameableSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::COMMAND => 'onCommand',
            ConsoleEvents::TERMINATE => 'onTerminate',
        ];
    }

    public function __construct(
        private BlameableListener $blameableListener,
    )
    {
    }

    public function onCommand(ConsoleCommandEvent $event): void
    {
        $this->blameableListener->setUserValue($event->getCommand()->getName());
    }

    public function onTerminate(ConsoleTerminateEvent $event): void
    {
        $this->blameableListener->setUserValue(null);
    }
}