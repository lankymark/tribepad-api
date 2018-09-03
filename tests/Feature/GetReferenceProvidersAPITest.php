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
        $response = $this->get('/api/reference/providers/10');
        $response->assertStatus(200);

        $content = $response->content();
        $this->assertJson($content);
        $this->assertTrue($content !== null);
        $content = json_decode($content, true);
        $this->assertTrue(is_array($content));
        $this->assertArrayHasKey('data', $content);
        $this->assertArrayHasKey('meta', $content);
        $this->assertArrayHasKey('links', $content);

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
        $meta = $content['meta'];
        $this->assertArrayHasKey('current_page', $meta);
        $this->assertArrayHasKey('last_page', $meta);
        $links = $content['links'];
        $this->assertArrayHasKey('first', $links);
        $this->assertArrayHasKey('prev', $links);
        $this->assertArrayHasKey('next', $links);
        $this->assertArrayHasKey('last', $links);
    }
}
