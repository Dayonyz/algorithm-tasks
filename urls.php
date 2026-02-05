<?php

function uniqueTopLevelDomainsUrlsCount(array $urls, bool $missProtocol = true): int
{
    $normalized = [];

    foreach ($urls as $url) {
        if (! is_string($url) || ! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Input parameter is not array of urls strings');
        }

        $parts = parse_url($url);
        $host  = $parts['host'] ?? null;

        if (!$host || substr_count($host, '.') !== 1) {
            continue;
        }

        parse_str($parts['query'] ?? '', $query);
        ksort($query);

        $path = rtrim($parts['path'] ?? '', '/');
        $queryString = $query ? '?' . http_build_query($query) : '';

        $normalized[] =
            ($missProtocol ? '' : ($parts['scheme'] ?? '') . '://')
            . $host
            . $path
            . $queryString;
    }

    return count(array_unique($normalized));
}

