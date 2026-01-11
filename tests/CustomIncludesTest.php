<?php

namespace Tests;

class CustomIncludesTest extends TestCase
{
    /**
     * Test that the custom includes controller is active
     *
     * @return void
     */
    public function testCustomIncludesController() {
        $this->get('/customincludescontroller');

        $this->assertResponseOk();
        $this->seeJsonStructure(['message']);
        $this->seeJson([
            'message' => 'Hi Custom Includes Controller!',
        ]);
    }
}
