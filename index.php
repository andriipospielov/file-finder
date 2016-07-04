<?php
$loader = require_once __DIR__ . '/vendor/autoload.php';


# search for all .conf or .ini files in directories /etc/ and /var/log/

$fileList = new FileFinder();

$fileList
    ->isDir()
    ->isFile()

    ->inDir('C:\Users\Andrei\Documents')
    ->inDir('C:\Users\Public\Pictures\Sample Pictures')
    ;
$files = $fileList->getList();
foreach ($files as $file) {
    print $file . "<br>";

}


/*
$fileList
    ->isFile()
    ->inDir('/etc/')
    ->inDir('/var/log/')
    ->match('/.*\.conf$/')
    ->match('/.*\.ini$/');
$files = $fileList->getList();
foreach ($files as $file) {
    print $file . "\n";
}

#  search for all files in /tmp
$fileList = (new FileFinderImplementation())
    ->inDir('/tmp')
    ->isFile();
$files = $fileList->getList();
foreach ($files as $file) {
    print $file . "\n";
}

#  search for .doc files in /tmp
$fileList = (new FileFinderImplementation())
    ->match('/.*\.doc$/')
    ->isFile()
    ->inDir('/tmp');
$files = $fileList->getList();
foreach ($files as $file) {
    print $file . "\n";
}

# should throw an exception if no dirs were provided
$files = (new FileFinderImplementation())
    ->isFile()
    ->match('/.*\.ini$/')
    ->getList(); # -> exception*/