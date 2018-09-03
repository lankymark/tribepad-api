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
        $this->get('/api/reference/test-'.date('Ymd'))
            ->assertStatus(200)
            ->assertJsonStructure([
               'data'   => [

                ],
                'meta'  => [

                ],
                'links' => [

                ]
            ]);
    }
}
