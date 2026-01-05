<?php

namespace Tests;

class HelloControllerTest extends TestCase
{
    /**
     * Test that the hello endpoint returns the correct JSON response
     *
     * @return void
     */
    public function testHelloEndpointReturnsCorrectJson()
    {
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
    public function testHelloEndpointReturnsValidJson()
    {
        $response = $this->call('GET', '/hello');

        $this->assertEquals(200, $response->status());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
    }

    /**
     * Test that the hello endpoint has the correct message structure
     *
     * @return void
     */
    public function testHelloEndpointMessageStructure()
    {
        $this->get('/hello');

        $this->assertResponseOk();

        $response = json_decode($this->response->getContent(), true);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('message', $response);
        $this->assertIsString($response['message']);
    }
}
