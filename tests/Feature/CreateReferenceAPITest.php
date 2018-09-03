<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

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
        $this->assertTrue(true);
        $original = $this->_mockData();
        $this->assertJson($original);
        $data = json_decode($original, true);
        $this->_checkKeys($data);
    }
}
