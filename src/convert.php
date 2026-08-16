<?php

declare(strict_types=1);

$root = dirname(__DIR__);

$f = fopen("$root/texts.txt", 'w');
foreach (file( "$root/hiero.txt") as $line) {
    $line = html_entity_decode($line);
    $line = preg_replace('#<hiero>|</ ?hiero>#', '', $line);
    fputs($f, $line . "\n");
}
fclose($f);
