<?php

use Symfony\CS\FixerInterface;

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('LICENSE')
    ->notName('README.md')
    ->notName('Bootstrap.php')
    ->notName('.php_cs')
    ->notName('composer.*')
    ->notName('build.xml')
    ->notName('phpunit.xml*')
    ->notName('*.phar')
    ->exclude('bin')
    ->exclude('nbproject')
    ->exclude('vendor')
    ->exclude('assets')
    ->exclude('tests/assets')
    ->exclude('tests/Bootstrap.php')
    ->in(__DIR__);

return Symfony\CS\Config\Config::create()->finder($finder);
