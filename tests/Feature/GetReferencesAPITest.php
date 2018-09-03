<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetReferencesAPITest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/api/references');
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
            $this->assertArrayHasKey('email', $data);
            $this->assertTrue(filter_var($data['email'], FILTER_VALIDATE_EMAIL) !== false);
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
