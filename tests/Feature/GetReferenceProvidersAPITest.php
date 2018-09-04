<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetReferenceProvidersAPITest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/api/reference/providers/test-'.date('Ymd'));
        $response->assertStatus(200);

        $content = $response->content();
        $this->assertJson($content);
        $this->assertTrue($content !== null);
        $content = json_decode($content, true);
        $this->assertTrue(is_array($content));
        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];
        if (!empty($data)) {
            $data = $data[0];
            $this->assertArrayHasKey('reference', $data);
            $this->assertArrayHasKey('provider', $data);
            $this->assertArrayHasKey('status', $data);
            $this->assertTrue(in_array($data['status'], ['passed', 'failed', 'pending']));
            $this->assertArrayHasKey('score', $data);
            $this->assertTrue($data['score'] >= 0);
            $this->assertTrue($data['score'] <= 50);
            $this->assertArrayHasKey('failed', $data);
            $this->assertArrayHasKey('created_at', $data);
            $this->assertArrayHasKey('updated_at', $data);
        }
    }
}
