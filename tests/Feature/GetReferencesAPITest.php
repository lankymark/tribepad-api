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

        $response->assertStatus(200)
            ->assertJsonStructure([
            'data' => [
                'reference',
                'email',
                'created_at',
                'updated_at'
            ],
            'meta' => [
                'current_page',
                'last_page'
            ],
            'links' => [
                'first',
                'next',
                'prev',
                'last'
            ]
        ]);
    }
}
