<?php

namespace DeejayFilesOrganizerBundle\Organizer\Rules;

use DeejayFilesOrganizerBundle\Organizer\MoveInstruction;
use Psr\Log\NullLogger;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

class FileGenreRule implements RuleInterface
{

    public function apply(MoveInstruction $mover)
    {
        $id3 = ($mover->getTagInfo());
        if (isset($id3['id3v2']['genre'][0])){
            $mover->addPathPart($id3['id3v2']['genre'][0]);
        }
    }

    public function getName()
    {
        return 'genre';
    }
}
