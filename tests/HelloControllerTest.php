<?php

namespace Tests;

use PATA\Db\FakeDb;
use PATA\Helpers\DbHelper;
use PATA\PATA;
use PATA\Security\FakeHash;

class HelloControllerTest extends TestCase
{
    /**
     * Create a database mock that returns a collection with specified count
     *
     * @param int $count Number of results to return
     * @return object Mock database connection
     */
    private function createDatabaseMock($count) {
        // Create an anonymous class that mimics Illuminate\Support\Collection
        $resultMock = new class ($count) {
            private $count;

            public function __construct($count) {
                $this->count = $count;
            }

            public function count() {
                return $this->count;
            }
        };

        // Create database query builder mock
        $dbMock = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['table', 'where', 'limit', 'get'])
            ->getMock();

        // Configure the database mock chain
        $dbMock->method('table')->willReturnSelf();
        $dbMock->method('where')->willReturnSelf();
        $dbMock->method('limit')->willReturnSelf();
        $dbMock->method('get')->willReturn($resultMock);

        return $dbMock;
    }

    /**
     * Test that the hello endpoint returns the correct JSON response
     *
     * @return void
     */
    public function testHelloEndpointReturnsCorrectJson() {
        $this->get('/hello');

        $this->assertResponseOk();
        $this->seeJsonStructure(['message']);
        $this->seeJson([
            'message' => 'Hello World!',
        ]);
    }

    /**
     * Test that the hello endpoint returns valid JSON
     *
     * @return void
     */
    public function testHelloEndpointReturnsValidJson() {
        $response = $this->call('GET', '/hello');

        $this->assertEquals(200, $response->status());
        $this->assertStringContainsString('application/json', $response->headers->get('Content-Type'));
    }

    /**
     * Test that the hello endpoint has the correct message structure
     *
     * @return void
     */
    public function testHelloEndpointMessageStructure() {
        $this->get('/hello');

        $this->assertResponseOk();

        $response = json_decode($this->response->getContent(), true);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('message', $response);
        $this->assertIsString($response['message']);
    }

    /**
     * Test withAuth endpoint with valid access token
     *
     * @return void
     */
    public function testWithAuthSuccessWithValidToken() {
        // Initialize PATA with FakeDb and FakeHash
        PATA::init([
            'dbHandler' => new FakeDb(),
            'hashHandler' => new FakeHash(),
        ]);

        // Create a valid token
        $validToken = 'valid-access-token';
        DbHelper::createToken([
            'data' => [
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
                'user_id' => 1,
                'sid' => 'test-session-id',
                'token' => $validToken,
                'token_type' => PATA::$accessTokenName ?? 'accessToken',
                'expiration' => time() + 3600, // 1 hour from now
            ],
        ]);

        // Make request with valid token
        $response = $this->call('GET', '/hello/withAuth', [], [], [], [
            'HTTP_' . strtoupper(str_replace('-', '_', PATA::$accessTokenName ?? 'accessToken')) => $validToken,
        ]);

        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'success' => true,
            'message' => 'Hello World withAuth!',
        ]);
    }

    /**
     * Test withAuth endpoint with invalid access token
     *
     * @return void
     */
    public function testWithAuthFailsWithInvalidToken() {
        // Initialize PATA with FakeDb and FakeHash
        PATA::init([
            'dbHandler' => new FakeDb(),
            'hashHandler' => new FakeHash(),
        ]);

        // Make request with invalid token (not in database)
        $response = $this->call('GET', '/hello/withAuth', [], [], [], [
            'HTTP_' . strtoupper(str_replace('-', '_', PATA::$accessTokenName ?? 'accessToken')) => 'invalid-token',
        ]);

        $this->assertEquals(401, $response->status());
        $this->seeJson([
            'success' => false,
        ]);
    }

    /**
     * Test withAuth endpoint with missing access token
     *
     * @return void
     */
    public function testWithAuthFailsWithMissingToken() {
        // Initialize PATA with FakeDb and FakeHash
        PATA::init([
            'dbHandler' => new FakeDb(),
            'hashHandler' => new FakeHash(),
        ]);

        // Make request without token
        $response = $this->call('GET', '/hello/withAuth');

        $this->assertEquals(401, $response->status());
        $this->seeJson([
            'success' => false,
        ]);
    }

    /**
     * Test withAuth endpoint with expired access token
     *
     * @return void
     */
    public function testWithAuthFailsWithExpiredToken() {
        // Initialize PATA with FakeDb and FakeHash
        PATA::init([
            'dbHandler' => new FakeDb(),
            'hashHandler' => new FakeHash(),
        ]);

        // Create an expired token
        $expiredToken = 'expired-access-token';
        DbHelper::createToken([
            'data' => [
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
                'user_id' => 1,
                'sid' => 'test-session-id-expired',
                'token' => $expiredToken,
                'token_type' => PATA::$accessTokenName ?? 'accessToken',
                'expiration' => time() - 3600, // 1 hour ago
            ],
        ]);

        // Make request with expired token
        $response = $this->call('GET', '/hello/withAuth', [], [], [], [
            'HTTP_' . strtoupper(str_replace('-', '_', PATA::$accessTokenName ?? 'accessToken')) => $expiredToken,
        ]);

        $this->assertEquals(401, $response->status());
        $this->seeJson([
            'success' => false,
        ]);
    }

    /**
     * Test withLoginApp endpoint with valid app token
     *
     * @return void
     */
    public function testWithLoginAppSuccessWithValidToken() {
        // Bind the mock to the app container
        $this->app->instance('db', $this->createDatabaseMock(1));

        // Make request with valid token
        $response = $this->call('GET', '/hello/withLoginApp', ['token' => 'valid-app-token']);

        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'success' => true,
            'message' => 'Hello World withLoginApp!',
        ]);
    }

    /**
     * Test withLoginApp endpoint with invalid app token
     *
     * @return void
     */
    public function testWithLoginAppFailsWithInvalidToken() {
        // Bind the mock to the app container
        $this->app->instance('db', $this->createDatabaseMock(0));

        // Make request with invalid token
        $response = $this->call('GET', '/hello/withLoginApp', ['token' => 'invalid-app-token']);

        $this->assertEquals(401, $response->status());
        $this->seeJson([
            'success' => false,
            'message' => 'Authentication failed',
            'code' => APP_ERROR_AUTH_ERROR,
        ]);
    }

    /**
     * Test withLoginApp endpoint with missing app token
     *
     * @return void
     */
    public function testWithLoginAppFailsWithMissingToken() {
        // Make request without token - no database mock needed as it should fail before DB query
        $response = $this->call('GET', '/hello/withLoginApp');

        $this->assertEquals(401, $response->status());
        $this->seeJson([
            'success' => false,
            'message' => 'Authentication failed',
            'code' => APP_ERROR_AUTH_ERROR,
        ]);
    }

    /**
     * Test withLoginApp endpoint with empty app token
     *
     * @return void
     */
    public function testWithLoginAppFailsWithEmptyToken() {
        // Make request with empty token - no database mock needed as it should fail before DB query
        $response = $this->call('GET', '/hello/withLoginApp', ['token' => '']);

        $this->assertEquals(401, $response->status());
        $this->seeJson([
            'success' => false,
            'message' => 'Authentication failed',
            'code' => APP_ERROR_AUTH_ERROR,
        ]);
    }

    /**
     * Test withLoginApp endpoint with token in header
     *
     * @return void
     */
    public function testWithLoginAppSuccessWithTokenInHeader() {
        // Bind the mock to the app container
        $this->app->instance('db', $this->createDatabaseMock(1));

        // Make request with valid token in header
        $response = $this->call('GET', '/hello/withLoginApp', [], [], [], [
            'HTTP_TOKEN' => 'valid-app-token-header',
        ]);

        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'success' => true,
            'message' => 'Hello World withLoginApp!',
        ]);
    }
}
