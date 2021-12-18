<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonControllerTest extends TestCase
{
    /**
     * @test
     */
    public function show() {
        $response = $this->get('/lesson/1');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('楽しいヨガレッスン');
        $response->assertSee('×');
    }
}
