<?php
declare(strict_types=1);
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PagesTest extends WebTestCase
{
    public function testHomePageReturnsSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Управление клиентами');
    }

    public function testHealthReturnsJson(): void
    {
        $client = static::createClient();
        $client->request('GET', '/health');
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');
        self::assertJsonContains(['status' => 'ok']);
    }

    public function testCustomerOneExists(): void
    {
        $client = static::createClient();
        $client->request('GET', '/customers/1');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Иван Иванов');
    }

    public function testUnknownUrlReturns404(): void
    {
        $client = static::createClient();
        $client->request('GET', '/unknown-url');
        self::assertResponseStatusCodeSame(404);
    }

    public function testInvalidCustomerIdDoesNotMatchRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/customers/0');
        self::assertResponseStatusCodeSame(404);
    }

    public function testMissingCustomerReturns404(): void
    {
        $client = static::createClient();
        $client->request('GET', '/customers/999');
        self::assertResponseStatusCodeSame(404);
    }

    public function testRequestInfoReturnsOnlyRequestedSafeFields(): void
    {
        $client = static::createClient();
        $client->request('GET', '/request-info?source=test', server: ['HTTP_USER_AGENT' => 'LabTest/1.0']);
        self::assertResponseIsSuccessful();
        self::assertJsonContains(['method' => 'GET', 'path' => '/request-info', 'query' => ['source' => 'test'], 'userAgent' => 'LabTest/1.0']);
    }
}
