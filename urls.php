<?php

/**
 * @throws Exception
 */
function uniqueTopLevelDomainsUrlsCount(array $urls, bool $missProtocol = true): int
{
    $isValidUrlsArray = function (array $urls): void {
        foreach ($urls as $url) {
            if (!is_string($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
                throw new \Exception('Input parameter is not array of urls strings');
            }
        }
    };

    $isValidUrlsArray($urls);

    $isTopLevelDomain = function (string $url): bool {
        $chunks  = parse_url($url);
        $host = $chunks['host'] ?? '';

        $topDomainLevel = explode('.', $host);

        return count($topDomainLevel) === 2;
    };

    $normalizedUrl = function (string $url, bool $missProtocol = true): string {
        $chunks = parse_url($url);
        $protocol = $chunks['scheme'] ?? '';
        $host = $chunks['host'] ?? '';

        $path = rtrim($chunks['path'] ?? '', '/');

        $uri = $chunks['query'] ?? '';
        $params = [];
        if ($uri !== '') {
            parse_str($uri, $params);
            ksort($params);
            $uri = '';
            foreach ($params as $param => $value) {
                $uri .= (strlen($uri) ? '&' : '') . $param . '=' . $value;
            }

        }

        return ($missProtocol ? '' : $protocol . '://') . $host . $path . (count($params) ? '?' . $uri : '');
    };

    foreach ($urls as $key => $url) {
        if ($isTopLevelDomain($url)) {
            $urls[$key] = $normalizedUrl($url, $missProtocol);
        } else {
            unset($urls[$key]);
        }
    }

    return count(array_unique($urls));
}
