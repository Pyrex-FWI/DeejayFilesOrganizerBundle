<?php

namespace DeejayFilesOrganizerBundle\Organizer\Rules;


use DeejayFilesOrganizerBundle\Organizer\MoveInstruction;

interface RuleInterface
{
    public function apply(MoveInstruction $mover);
    public function getName();
}