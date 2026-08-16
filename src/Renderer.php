<?php

declare(strict_types=1);

namespace MaxSem\HieroComparison;

interface Renderer
{
    public function render(string $markup): string;
}
