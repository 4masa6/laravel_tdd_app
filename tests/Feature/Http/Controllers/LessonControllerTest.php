<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function show() {

        $lesson = factory(Lesson::class)->create(['name' => '楽しいヨガレッスン']);

        $response = $this->get("/lesson/{$lesson->id}");

        $response->assertStatus(Response::HTTP_OK);

        $response->assertSee($lesson->name);
        $response->assertSee('空き状況: ×');
    }
}
