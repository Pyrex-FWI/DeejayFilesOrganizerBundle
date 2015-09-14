<?php
/**
 * Date: 06/09/15
 * Time: 11:56
 */

namespace DeejayFilesOrganizerBundle\Organizer;


use DeejayFilesOrganizerBundle\Event\FileMovedEvent;
use DeejayFilesOrganizerBundle\Event\OrganizerEvents;
use DeejayFilesOrganizerBundle\Organizer\Rules\RuleInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Filesystem\Filesystem;

class OrganizerManager
{
    /** @var array RuleInterface[] */
    private $rules = [];
    /** @var  EventDispatcher */
    protected $eventDispatcher;
    /**
     * @var Logger;
     */
    protected $logger;

    public function __construct(
        $eventDispatcher,
        Logger $logger = null)
    {
        $this->logger               = $logger ? $logger : new NullLogger();
        $this->eventDispatcher      = $eventDispatcher;
    }

    public function addRule(RuleInterface $rule)
    {
        $this->rules[$rule->getName()] = $rule;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function get($name)
    {
        if (!isset($this->rules[$name])) {
            throw new \Exception(sprintf('%s rule not Found', $name));
        }

        return $this->rules[$name];
    }

    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param $outPath
     * @param $file
     * @param $rules
     */
    public function apply($outPath, $file, $rules)
    {
        $moveInstruc = new MoveInstruction($outPath, $file);
        foreach ($rules as $rule) {

            $this->get($rule)->apply($moveInstruc);
        }


        if ($moveInstruc->getOrigin() === $moveInstruc->getFinalDestination()) return;

        $dir = (new \SplFileInfo($moveInstruc->getFinalDestination()))->getPath();

        $fsys = new Filesystem();
        if (!is_dir($dir)) {
            $fsys->mkdir($dir);
        }
        try {
            $fsys->rename($moveInstruc->getOrigin(), $moveInstruc->getFinalDestination());
            $this->eventDispatcher->dispatch(OrganizerEvents::FILE_HAS_MOVED, new FileMovedEvent($moveInstruc));
            $this->logger->info(sprintf('move %s to %s',
                $moveInstruc->getOrigin(),
                $moveInstruc->getFinalDestination()
            ));
        } catch (\Exception $e) {
            //$this->setMessage($message);
        }
        /*dump();*/
    }
}