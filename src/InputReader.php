<?php

declare(strict_types=1);

namespace MaxSem\HieroComparison;

class InputReader
{
    public function __construct(
        private readonly string $filename,
    ) {
    }


    public function texts(): iterable
    {
        $lines = file($this->filename) or throw new Exception("Error reading file '{$this->filename}'");
        $lines[] = '';

        $result = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' && $result) {
                yield implode("\n", $result);
                $result = [];
            } else {
                $result[] = $line;
            }
        }
    }
}
