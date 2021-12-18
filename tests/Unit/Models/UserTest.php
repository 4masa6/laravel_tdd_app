<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Lesson;
use Mockery;

class UserTest extends TestCase
{
    /**
     * @test canReserve
     * @param string $plan
     * @param int $remainingCount
     * @dataProvider dataCanReserve_正常
     */
    public function canReserve_正常：ユーザープランと月間予約回数に応じて、レッスンを予約できるか判定する(string $plan, int $remainingCount, int $reservationCount) {

        /** @var User $user */
        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('reservationCountThisMonth')->andReturn($reservationCount);
        $user->plan = $plan;

        /** @var Lesson $lesson */
        $lesson = Mockery::mock(Lesson::class);
        $lesson->shouldReceive('remainingCount')->andReturn($remainingCount);

        $user->canReserve($lesson);
        // 例外が出ないことを確認するアサーションがないので代わりに
        $this->assertTrue(true);
    }

    /**
     * @test canReserve
     * @param string $plan
     * @param int $remainingCount
     * @param int $reservationCount
     * @param string $errorMessage
     * @dataProvider dataCanReserve_エラー
     */
    public function canReserve_エラー：ユーザープランと月間予約回数に応じて、レッスンを予約できるか判定する(string $plan, int $remainingCount, int $reservationCount, string $errorMessage) {

        /** @var User $user */
        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('reservationCountThisMonth')->andReturn($reservationCount);
        $user->plan = $plan;

        /** @var Lesson $lesson */
        $lesson = Mockery::mock(Lesson::class);
        $lesson->shouldReceive('remainingCount')->andReturn($remainingCount);

        $this->expecteExceptionMessage($errorMessage);

        $user->canReserve($lesson);

    }

    public function dataCanReserve_正常() {
        return [
            '予約可:レギュラー,空きあり,月の上限以下' => [
                'plan' => 'regular',
                'remainingCount' => 1,
                'reservationCount' => 4,
                'canReserve' => true,
            ],
            '予約可:ゴールド,空きあり' => [
                'plan' => 'gold',
                'remainingCount' => 1,
                'reservationCount' => 5,
                'canReserve' => true,
            ],
        ];
    }

    public function dataCanReserve_エラー() {
        return [
            '予約不可:レギュラー,空きあり,月の上限' => [
                'plan' => 'regular',
                'remainingCount' => 1,
                'reservationCount' => 5,
                'canReserve' => false,
            ],
            '予約不可:レギュラー,空きなし,月の上限以下' => [
                'plan' => 'regular',
                'remainingCount' => 0,
                'reservationCount' => 4,
                'canReserve' => false,
            ],
            '予約不可:ゴールド,空きなし' => [
                'plan' => 'gold',
                'remainingCount' => 0,
                'reservationCount' => 5,
                'canReserve' => false,
            ],
        ];
    }
}
