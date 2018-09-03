<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreateReferenceAPITest extends TestCase
{
    private function _mockData()
    {
        return json_encode([
            'reference'     => 'test-'.date('Ymd'),
            'email'         => 'test@test.com',
            'providers'     => [
                'mind-x'    => [
                    'status'    => 'passed',
                    'score'     => 13,
                    'failed'    => 2
                ],
                'sh1'    => [
                    'status'    => 'passed',
                    'score'     => 29,
                    'failed'    => 2
                ],
                'talentq'    => [
                    'status'    => 'failed',
                    'score'     => 2,
                    'failed'    => 25
                ]
            ]
        ]);
    }

    private function _checkKeys($data)
    {
        $this->assertArrayHasKey('reference', $data);
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('providers', $data);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $data = $this->_mockData();

        $this->assertJson($data);

        $data = json_decode($data);

        $this->_checkKeys($data);

        $this->json('POST', '/api/references', $data)
            ->assertStatus(200)
            ->assertJson(['Success' => 1])
            ->assertJsonStructure([
                'Success', 'Message'
            ]);
    }
}
