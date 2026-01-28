<?php

namespace Tests\Services\Organizations;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SentDm\Client;
use SentDm\Organizations\Users\CustomerUser;
use SentDm\Organizations\Users\UserListResponse;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class UsersTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(
            apiKey: 'My API Key',
            senderID: 'My Sender ID',
            baseUrl: $testUrl,
        );

        $this->client = $client;
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->organizations->users->retrieve(
            '650e8400-e29b-41d4-a716-446655440000',
            customerID: '550e8400-e29b-41d4-a716-446655440000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CustomerUser::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->organizations->users->retrieve(
            '650e8400-e29b-41d4-a716-446655440000',
            customerID: '550e8400-e29b-41d4-a716-446655440000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CustomerUser::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->organizations->users->list(
            '550e8400-e29b-41d4-a716-446655440000',
            page: 0,
            pageSize: 0
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserListResponse::class, $result);
    }

    #[Test]
    public function testListWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->organizations->users->list(
            '550e8400-e29b-41d4-a716-446655440000',
            page: 0,
            pageSize: 0
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->organizations->users->delete(
            '650e8400-e29b-41d4-a716-446655440000',
            customerID: '550e8400-e29b-41d4-a716-446655440000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->organizations->users->delete(
            '650e8400-e29b-41d4-a716-446655440000',
            customerID: '550e8400-e29b-41d4-a716-446655440000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testInvite(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->organizations->users->invite(
            '550e8400-e29b-41d4-a716-446655440000'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CustomerUser::class, $result);
    }

    #[Test]
    public function testUpdateRole(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->organizations->users->updateRole(
            '650e8400-e29b-41d4-a716-446655440000',
            customerID: '550e8400-e29b-41d4-a716-446655440000',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CustomerUser::class, $result);
    }

    #[Test]
    public function testUpdateRoleWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->organizations->users->updateRole(
            '650e8400-e29b-41d4-a716-446655440000',
            customerID: '550e8400-e29b-41d4-a716-446655440000',
            role: 'admin',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CustomerUser::class, $result);
    }
}
