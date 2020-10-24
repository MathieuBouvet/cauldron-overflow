<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownCacher
{
    private MarkdownParserInterface $markdownParser;
    private CacheInterface $cache;
    private LoggerInterface $logger;
    private bool $isDebug;

    public function __construct(
        MarkdownParserInterface $markdownParser,
        CacheInterface $cache,
        LoggerInterface $mdooLogger,
        bool $isDebug
    ) {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
        $this->logger = $mdooLogger;
        $this->isDebug = $isDebug;
    }
    public function parse(string $source): string
    {
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
