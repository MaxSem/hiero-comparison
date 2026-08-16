<?php

declare(strict_types=1);

namespace MaxSem\HieroComparison;

use MaxSem\Hiero\Error;
use MaxSem\Hiero\Font;
use MaxSem\Hiero\ManuelDeCodage;
use MaxSem\Hiero\Options;

class SvgRenderer implements Renderer
{
    private const PIXELS_PER_LINE = 40;

    private readonly ManuelDeCodage $manuelDeCodage;
    private readonly string $dir;
    private readonly string $extDir;

    public function __construct(string $fontName)
    {
        $font = is_dir($fontName)
            ? Font::fromPath($fontName)
            : Font::fromComposerPackage($fontName);

        $options = new Options(
            throwOnErrors: false,
            maxTokens: 1000,
        );

        $this->manuelDeCodage = new ManuelDeCodage($options, $font);

        $shortName = preg_replace('#^.*[-/_]#', '', $fontName);

        $this->dir = dirname(__DIR__) . "/public/svg/$shortName";
        @mkdir($this->dir, recursive: true);

        $this->extDir = "svg/$shortName";
    }

    public function render(string $markup): string
    {
        $output = $this->manuelDeCodage->parseAndRender($markup);
        $hash = md5($markup);
        $file = "{$this->dir}/$hash.svg";
        file_put_contents($file, $output->svg);
        $height = intval($output->viewBox->height * self::PIXELS_PER_LINE / $output->charHeight);

        $html = "<img src='{$this->extDir}/$hash.svg' height='$height' />";

        if ($output->errors) {
            $errors = array_map(fn (Error $e) => [$e->key, ...$e->backtrace], $output->errors);
            $errors = json_encode($errors, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            $errors = htmlspecialchars($errors);
            $errors = nl2br($errors);
            $html .= "\n<br/>Errors: <span class='errors'>\n$errors</span>";
        }

        return $html;
    }
}
