<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateReferenceAPIValidationTest extends TestCase
{
    private function _mockData()
    {
        return [
            'reference'     => 'test-'.date('Ymd'),
            'email'         => 'testtest.com',
            'providers'     => [
                'mind-x'    => [
                    'status'    => 'passed',
                    'score'     => 51,
                    'failed'    => 2
                ],
                'sh1'    => [
                    'status'    => 'passed2',
                    'score'     => 29,
                    'failed'    => 2
                ],
                'talentq'    => [
                    'status'    => 'failed',
                    'score'     => '-2',
                    'failed'    => 25
                ]
            ]
        ];
    }

    private function _testProviderKeys($provider)
    {
        $this->assertTrue(is_array($provider));
        $this->assertArrayHasKey('status', $provider);
        $this->assertArrayHasKey('score', $provider);
        $this->assertArrayHasKey('failed', $provider);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $data = $this->_mockData();

        $this->assertTrue(is_array($data));
        $this->assertTrue(filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false);
        $this->assertArrayHasKey('providers', $data);
        if (!empty($data['providers'])) {
            $provider = $data['providers']['mind-x'];
            $this->_testProviderKeys($provider);
            $this->assertTrue(in_array($provider['status'], ['passed', 'failed', 'pending']));
            $this->assertTrue($provider['score'] >= 0);
            $this->assertTrue(($provider['score'] <= 50) === false); // We expect this to false as the value is 51

            $provider = $data['providers']['sh1'];
            $this->_testProviderKeys($provider);
            $this->assertTrue(in_array($provider['status'], ['passed', 'failed', 'pending']) === false); // we expect this to be false as the value isn't valid
            $this->assertTrue($provider['score'] >= 0);
            $this->assertTrue($provider['score'] <= 50);

            $provider = $data['providers']['talentq'];
            $this->_testProviderKeys($provider);
            $this->assertTrue(in_array($provider['status'], ['passed', 'failed', 'pending']));
            $this->assertTrue(($provider['score'] >= 0) === false); // we expect this to be false as the value is -2
            $this->assertTrue($provider['score'] <= 0);

            // Test that this data fails correctly
            $response = $this->json('post', '/api/reference', $data);
            $response->assertStatus(400);
            $content = $response->content();
            $this->assertJson($content);
            $this->assertTrue($content !== null);
            $content = json_decode($content, true);
            $this->assertTrue(is_array($content));
            $this->assertArrayHasKey('email', $content);
            $this->assertArrayHasKey('providers.mind-x.score', $content);
            $this->assertArrayHasKey('providers.talentq.score', $content);
            $this->assertArrayHasKey('providers.sh1.status', $content);
        }
    }
}
