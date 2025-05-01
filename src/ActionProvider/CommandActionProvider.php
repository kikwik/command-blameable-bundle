<?php

namespace Kikwik\CommandBlameableBundle\ActionProvider;

use Gedmo\Tool\ActorProviderInterface;

class CommandActionProvider implements ActorProviderInterface
{
    public function __construct(
        private string $commandName
    )
    {
    }

    public function getActor()
    {
        return $this->commandName;
    }

}