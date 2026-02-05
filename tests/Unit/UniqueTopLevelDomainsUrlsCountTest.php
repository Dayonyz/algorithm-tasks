<?php

namespace Tests\Unit;

use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UniqueTopLevelDomainsUrlsCountTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testReturnsUniqueCountWithMissProtocolTrue(): void
    {
        $urls = [
            'https://example.com',
            'https://example.com/',
            'https://example.com?b=2&a=1',
            'https://example.com?a=1&b=2',
            'https://test.org',
        ];

        $this->assertSame(3, uniqueTopLevelDomainsUrlsCount($urls, true));
    }

    /**
     * @throws Exception
     */
    public function testReturnsUniqueCountWithMissProtocolFalse(): void
    {
        $urls = [
            'https://example.com',
            'http://example.com',
            'https://example.com?a=1&b=2',
            'https://example.com?b=2&a=1',
        ];

        $this->assertSame(3, uniqueTopLevelDomainsUrlsCount($urls, false));
    }

    /**
     * @throws Exception
     */
    public function testFiltersOutNonTopLevelDomains(): void
    {
        $urls = [
            'https://sub.example.com',
            'https://sub.sub.example.com',
            'https://domain.co.uk',
            'https://another.org',
            'https://valid.com',
        ];

        $this->assertSame(2, uniqueTopLevelDomainsUrlsCount($urls)); // only another.org, valid.com
    }

    public function testThrowsExceptionOnInvalidUrls(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Input parameter is not array of urls strings');

        uniqueTopLevelDomainsUrlsCount(['invalid-url', 123, null]);
    }

    /**
     * @throws Exception
     */
    public function testReturnsZeroForEmptyInput(): void
    {
        $this->assertSame(0, uniqueTopLevelDomainsUrlsCount([]));
    }

    /**
     * @throws Exception
     */
    public function testIgnoresTrailingSlashesAndSortsQueryParams(): void
    {
        $urls = [
            'https://foo.com/path/',
            'https://foo.com/path',
            'https://foo.com/path?a=2&b=1',
            'https://foo.com/path?b=1&a=2',
        ];

        $this->assertSame(2, uniqueTopLevelDomainsUrlsCount($urls, true));
    }

    /**
     * @throws Exception
     */
    public function testWorksWithUrlsWithoutPath(): void
    {
        $urls = [
            'https://abc.com',
            'https://abc.com/',
        ];

        $this->assertSame(1, uniqueTopLevelDomainsUrlsCount($urls, true));
    }
}
