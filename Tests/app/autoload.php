<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

$loader = require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/AppKernel.php';


AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
