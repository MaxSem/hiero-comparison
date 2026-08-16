<?php

declare(strict_types=1);

namespace MaxSem\HieroComparison;

use WikiHiero\WikiHiero;

class HtmlRenderer implements Renderer
{
    private readonly WikiHiero $wikiHiero;

    public function __construct()
    {
        $this->wikiHiero = new WikiHiero();
    }

    public function render(string $markup): string
    {
        return $this->wikiHiero->render($markup);
    }
}
