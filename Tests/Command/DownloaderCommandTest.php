<?php
/**
 * User: chpyr
 * Date: 11/04/15
 * Time: 16:11
 */

namespace DeejayFilesOrganizerBundle\Tests\Command;

use DigitalDjPool\Tests\BaseTest;
use DigitalDjPoolBundle\Command\DownloaderCommand;
use Symfony\Component\Console\Tester\CommandTester;

class DownloaderCommandTest extends \DeejayFilesOrganizerBundle\Tests\BaseTest
{

    public function testAvdExecute()
    {
        return;
        $kernel         = new \AppKernel('test', true);
        $application    = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $kernel->boot();
        $application->add($this->container->get('deejay_pool.command.download'));

        /** @var \DeejayFilesOrganizerBundle\Command\DownloaderCommand $command */
        $command        = $application->find('deejay:pool:download');
        $commandTester  = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'provider'  => 'av_district',
            '--start'   => 100,
            '--end'     => 102,
            '--sleep'   => 10,
            '-vvv'
        ]);

        foreach ($command->getDownloadSuccess() as $avItem) {
            if ($avItem->getFullPath() && file_exists($avItem->getFullPath())) {
                unlink($avItem->getFullPath());
            }
        }
        $this->assertEquals(150 - count($command->getDownloadError()), count($command->getDownloadSuccess()));
        $this->assertEquals(150 - count($command->getDownloadSuccess()), count($command->getDownloadError()));
        $this->assertRegExp('/Read page 100/', $commandTester->getDisplay());
        $this->assertRegExp('/Read page 101/', $commandTester->getDisplay());
        $this->assertRegExp('/Read page 102/', $commandTester->getDisplay());
        $this->assertRegExp('|3/3|', $commandTester->getDisplay());
        $this->assertRegExp('|150/150|', $commandTester->getDisplay());
        echo $commandTester->getDisplay();
    }

}

