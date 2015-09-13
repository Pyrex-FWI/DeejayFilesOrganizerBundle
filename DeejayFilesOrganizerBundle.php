<?php

namespace DeejayFilesOrganizerBundle;

use DeejayFilesOrganizerBundle\DependencyInjection\Compiler\RuleCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DeejayFilesOrganizerBundle extends Bundle
{

    const BUNDLE_ALIAS      = 'deejay_files_organizer';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RuleCompilerPass());
    }
}
