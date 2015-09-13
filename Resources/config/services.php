<?php

use DeejayFilesOrganizerBundle\DeejayFilesOrganizerBundle;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

$organizerManager = DeejayFilesOrganizerBundle::BUNDLE_ALIAS.'.rule_manager';
$container->setParameter(
    $organizerManager.'.class',
    'DeejayFilesOrganizerBundle\Organizer\OrganizerManager'
);

$monthRule = DeejayFilesOrganizerBundle::BUNDLE_ALIAS.'.rule_month';
$container->setParameter(
    $monthRule.'.class',
    'DeejayFilesOrganizerBundle\Organizer\Rules\FileMonthRule'
);

$genreRule = DeejayFilesOrganizerBundle::BUNDLE_ALIAS.'.rule_genre';
$container->setParameter(
    $genreRule.'.class',
    'DeejayFilesOrganizerBundle\Organizer\Rules\FileGenreRule'
);


$container
    ->setDefinition(
        $organizerManager,
        new Definition(
            '%'.$organizerManager.'.class%',
            []
        )
    )
;


$container
    ->setDefinition(
        $monthRule,
        new Definition(
            '%'.$monthRule.'.class%',
            array(
                //new Reference('event_dispatcher'),
                //new Reference('logger', \Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_INVALID_REFERENCE)
            ))
    )
    ->addTag(DeejayFilesOrganizerBundle::BUNDLE_ALIAS.'_rule', []);


$container
    ->setDefinition(
        $genreRule,
        new Definition(
            '%'.$genreRule.'.class%',
            array(
            ))
    )
    ->addTag(DeejayFilesOrganizerBundle::BUNDLE_ALIAS.'_rule', []);
