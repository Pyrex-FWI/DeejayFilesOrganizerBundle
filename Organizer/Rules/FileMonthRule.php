<?php

namespace DeejayFilesOrganizerBundle\Organizer\Rules;

use DeejayFilesOrganizerBundle\Organizer\MoveInstruction;
use Psr\Log\NullLogger;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

class FileMonthRule implements RuleInterface
{

    public function apply(MoveInstruction $mover)
    {
        $newPart = (new \DateTime('@'.$mover->getFsys()->getCTime()))->format('F');
        $mover->addPathPart($newPart);
    }

    public function getName()
    {
        return 'created_month';
    }
}
