<?php

namespace DeejayFilesOrganizerBundle\Tests\Provider;

use DeejayFilesOrganizerBundle\Organizer\MoveInstruction;
use DeejayFilesOrganizerBundle\Organizer\OrganizerManager;
use DeejayFilesOrganizerBundle\Organizer\Rules\FileGenreRule;
use DeejayFilesOrganizerBundle\Organizer\Rules\FileMonthRule;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author "Pyrex-Fwi" <yemistikrys@gmail.com>
 */
class OrganizerTest extends \DeejayFilesOrganizerBundle\Tests\BaseTest
{

    protected function setUp()
    {
        parent::setUp();
    }

    public function testOne()
    {
        /** @var OrganizerManager $manager */
        $manager = $this->container->get('deejay_files_organizer.rule_manager');
        $rules = ['created_month' ,'genre'];
        $finder = Finder::create();
        $finder->in('/Users/chpyr/Music/DDP/')->name('*.mp3')->files();
        foreach($finder as $file) {
            /** @var SplFileInfo $file */
            $manager->apply('/Users/chpyr/Music/DDP/', $file->getPathname(), $rules);
        }

    }

}
