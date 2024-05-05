<?php

namespace Household\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Generator;

class HouseholdControllerTest extends WebTestCase
{
    public function householdTypeProvider(): Generator
    {
        yield ['family'];
        yield ['roommates'];
    }

    public function wrongHouseholdTypeProvider(): Generator
    {
        yield ['wrongHouseholdType'];
    }

    /**
     * @dataProvider householdTypeProvider
     */
    public function testCreateHousehold(string $familyType): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/household/household/create', [
            'type' => $familyType,
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    /**
     * @dataProvider householdTypeProvider
     */
    public function testKeysOfCreateHouseholdResponse(string $familyType): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/household/household/create', [
            'type' => $familyType,
        ]);

        $response = $client->getResponse();
        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $responseContent);
        $this->assertArrayHasKey('type', $responseContent);
        $this->assertArrayHasKey('users', $responseContent);
    }

    /**
     * @dataProvider wrongHouseholdTypeProvider
     */
    public function testCreateHouseholdWithWrongCredentials(string $familyType): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/household/household/create', [
            'type' => $familyType,
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertEquals('"Invalid household type"', $client->getResponse()->getContent());
    }

    public function testGetHousehold(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/household/household/get/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testKeysOfGetHouseholdResponse(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/household/household/get/1');

        $response = $client->getResponse();
        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $responseContent);
        $this->assertArrayHasKey('type', $responseContent);
        $this->assertArrayHasKey('users', $responseContent);
    }

    public function testGetHouseholdWithWrongId(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/household/household/get/0');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider householdTypeProvider
     */
    public function testUpdateHouseholdType(string $familyType): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/household/household/update-type/1', [
            'type' => $familyType,
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @dataProvider householdTypeProvider
     */
    public function testKeysOfUpdateHouseholdTypeResponse(string $familyType): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/household/household/update-type/1', [
            'type' => $familyType,
        ]);

        $response = $client->getResponse();
        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $responseContent);
        $this->assertArrayHasKey('type', $responseContent);
        $this->assertArrayHasKey('users', $responseContent);
    }

    public function testDeleteHousehold(): void
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/v1/household/household/delete/3');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testKeysOfDeleteHouseholdResponse(): void
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/v1/household/household/delete/3');

        $response = $client->getResponse();
        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $responseContent);
        $this->assertArrayHasKey('type', $responseContent);
        $this->assertArrayHasKey('users', $responseContent);
    }
}
