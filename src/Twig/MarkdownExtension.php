<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Service\MarkdownCacher;

class MarkdownExtension extends AbstractExtension
{
    private MarkdownCacher $markdownCacher;
    public function __construct(MarkdownCacher $markdownCacher)
    {
        $this->markdownCacher = $markdownCacher;
    }
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter(
                'cached_parse',
                [$this, 'doSomething'],
                ['is_safe' => ['html']],
            ),
        ];
    }

    public function doSomething($value)
    {
        return $this->markdownCacher->parse($value);
    }
}
