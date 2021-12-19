<?php

namespace Tests\Feature\Http\Controllers\Lesson;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Factories\Traits\CreatesUser;

class ReserveControllerTest extends TestCase
{
    use RefreshDatabase, CreatesUser;

    /**
     * @test invoke
     */
    public function invoke() {
        $lesson = factory(Lesson::class)->create();
        $user = $this->createUser();
        $this->actingAs($user); // $userをログイン状態にする記述

        $response = $this->post('/lessons/{$lesson->id}/reserve');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/lessons/{$lesson->id}');
    }
}
