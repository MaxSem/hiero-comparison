<?php

declare(strict_types=1);

namespace MaxSem\HieroComparison;

class ParallelRenderer
{
    private const GENERATORS = [
        'Old HTML' => [HtmlRenderer::class],
        'SVG NewGardiner' => [SvgRenderer::class, 'maxsem/hiero-font-newgardiner'],
    ];

    /** @var array<string, Renderer> */
    private readonly array $renderers;

    public function __construct()
    {
        $this->renderers = array_map(fn($params) => $this->make($params), self::GENERATORS);
    }

    /**
     * @return array<string, string>
     */
    public function render(string $markup): array
    {
        return array_map(fn($r) => $r->render($markup), $this->renderers);
    }

    private function make(array $params): Renderer
    {
        $class = array_shift($params);

        return new $class(...$params);
    }
}
