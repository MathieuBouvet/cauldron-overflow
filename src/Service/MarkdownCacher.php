<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownCacher
{
    public function __construct(
        MarkdownParserInterface $markdownParser,
        CacheInterface $cache,
        LoggerInterface $markdownLogger,
        bool $isDebug
    ) {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
        $this->logger = $markdownLogger;
        $this->isDebug = $isDebug;
    }
    public function parse(string $source): string
    {
        dump($this->logger);
        if (stripos($source, 'cat') !== false) {
            $this->logger->info('Meow!');
        }
        if ($this->isDebug) {
            return $this->markdownParser->transformMarkdown($source);
        }
        return $this->cache->get('markdown_' . md5($source), function () use (
            $source
        ) {
            return $this->markdownParser->transformMarkdown($source);
        });
    }
}
