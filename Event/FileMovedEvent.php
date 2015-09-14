<?php

namespace DeejayFilesOrganizerBundle\Event;


use DeejayFilesOrganizerBundle\Entity\AvdItem;
use DeejayFilesOrganizerBundle\Entity\ProviderItemInterface;
use DeejayFilesOrganizerBundle\Organizer\MoveInstruction;
use Symfony\Component\EventDispatcher\Event;

class FileMovedEvent extends Event {

    /** @var MoveInstruction  */
    protected $item;
    /**
     * @param AvdItem $item
     */
    public function __construct(MoveInstruction $item)
    {
        $this->setItem($item);
    }

    /**
     * @return AvdItem
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param AvdItem $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }
}