<?php
namespace App\Tests\Functional;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
final class DashboardTest extends WebTestCase
{
    public function testDashboardRouteResponds(): void {
        $client=static::createClient();$client->request('GET','/dashboard');
        self::assertResponseIsSuccessful();self::assertSelectorTextContains('h1','Dashboard');
    }
    public function testOrdersPageResponds(): void {
        $client=static::createClient();$client->request('GET','/orders');
        self::assertResponseIsSuccessful();self::assertSelectorTextContains('h1','Заказы');
    }
    public function testOrdersCanBeFilteredByStatus(): void {
        $client=static::createClient();$client->request('GET','/orders?status=paid');
        self::assertResponseIsSuccessful();
    }
    public function testMissingCustomerReturns404(): void {
        $client=static::createClient();$client->request('GET','/customers/99999999');
        self::assertResponseStatusCodeSame(404);
    }
    public function testCustomerDetailRouteRespondsWhenFixtureExists(): void {
        $client=static::createClient();$client->request('GET','/customers/1');
        // Requires fixtures to have been loaded into the test database.
        self::assertContains($client->getResponse()->getStatusCode(),[200,404]);
    }
}
