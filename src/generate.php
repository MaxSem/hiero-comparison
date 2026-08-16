<?php

declare(strict_types=1);

use MaxSem\HieroComparison\InputReader;
use MaxSem\HieroComparison\ParallelRenderer;

require __DIR__ . '/../vendor/autoload.php';

$root = dirname(__DIR__);

$dest = "$root/public/index.html";

$renderer = new ParallelRenderer();
$reader = new InputReader("$root/texts.txt");

$output = [];
foreach ($reader->texts() as $text) {
    $output[$text] = $renderer->render($text);
    if (count($output) === 1000) {
        break;
    }
}

ob_start();
require __DIR__ . '/template.php';
$html = ob_get_clean();

file_put_contents($dest, $html);
