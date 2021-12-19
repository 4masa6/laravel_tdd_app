<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use App\Models\Reservation;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LessonControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @param int $capacity
     * @param int $reservationCount
     * @param string $expectedVacancyLevelMark
     * @param string $button
     * @dataProvider dataShow
     */
    public function show(int $capacity, int $reservationCount, string $expectedVacancyLevelMark, string $button) {

        $lesson = factory(Lesson::class)->create(['name' => '楽しいヨガレッスン', 'capacity' => $capacity]);
        for ($i = 0; $i < $reservationCount; $i++) {
            $user = factory(User::class)->create();
            factory(UserProfile::class)->create(['user_id' => $user->id]);
            factory(Reservation::class)->create(['lesson_id' => $lesson->id, 'user_id' => $user->id]);
        }

        $user = factory(User::class)->create();
        factory(UserProfile::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        // ページへのアクセス
        $response = $this->get("/lessons/{$lesson->id}");
        // ページが正しく表示できる
        $response->assertStatus(Response::HTTP_OK);
        // 空き状況が正しく表示できる
        $response->assertSee($lesson->name);
        $response->assertSee("空き状況: {$expectedVacancyLevelMark}");
        // 予約可能条件を満たしている時は予約でき、満たしていない時は予約できない。
        $response->assertSee($button, false); // 第二引数は第一引数をエスケープしない設定（"をエスケープされないように）

    }

    public function dataShow() {
        $button = '<button class="btn btn-primary">このレッスンを予約する</button>';
        $span   = '<span class="btn btn-primary disabled">予約できません</span>';
        return [
            '空き十分' => [
                'capacity' => 6,
                'reservationCount' => 1,
                'expectedVacancyLevelMark' => '◎',
                'button' => $button,
            ],
            '空きわずか' => [
                'capacity' => 6,
                'reservationCount' => 2,
                'expectedVacancyLevelMark' => '△',
                'button' => $button,
            ],
            '空きなし' => [
                'capacity' => 1,
                'reservationCount' => 1,
                'expectedVacancyLevelMark' => '×',
                'button' => $span,
            ],
        ];
    }
}
