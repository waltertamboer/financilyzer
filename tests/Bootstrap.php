<?php
// Financilyzer needs to function with all errors enabled:
error_reporting(E_ALL | E_STRICT);

if (class_exists('PHPUnit_Runner_Version', true)) {
    $phpUnitVersion = PHPUnit_Runner_Version::id();
    if ('@package_version@' !== $phpUnitVersion && version_compare($phpUnitVersion, '3.7.0', '<')) {
        echo 'This version of PHPUnit (' . PHPUnit_Runner_Version::id() . ') is not supported.' . PHP_EOL;
        exit(1);
    }
    unset($phpUnitVersion);
}

$codeCoverageFilter = new PHP_CodeCoverage_Filter();
$codeCoverageFilter->addDirectoryToWhitelist(__DIR__ . '/../src');
$codeCoverageFilter->addDirectoryToBlacklist(__DIR__, '');
$codeCoverageFilter->addDirectoryToBlacklist(__DIR__ . '/../vendor', '');
$codeCoverageFilter->addDirectoryToBlacklist(PEAR_INSTALL_DIR, '');
$codeCoverageFilter->addDirectoryToBlacklist(PHP_LIBDIR, '');
unset($codeCoverageFilter);
