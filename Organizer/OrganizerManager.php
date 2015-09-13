<?php
/**
 * Date: 06/09/15
 * Time: 11:56
 */

namespace DeejayFilesOrganizerBundle\Organizer;


use DeejayFilesOrganizerBundle\Organizer\Rules\RuleInterface;
use Symfony\Component\Filesystem\Filesystem;

class OrganizerManager
{
    /** @var array RuleInterface[] */
    private $rules = [];

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
        $fsys->rename($moveInstruc->getOrigin(), $moveInstruc->getFinalDestination());
        /*dump(sprintf('move %s to %s',
            $moveInstruc->getOrigin(),
            $moveInstruc->getFinalDestination()
        ));*/
    }
}