<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @test canReserve
     * string $plan
     * int $remainingCount
     * int $reservationCount
     * bool $canReserve
     * @dataProvider dataCanReserve
     */
    public function ユーザーが正常に予約できる(string $plan, int $remainingCount, int $reservationCount, bool $canReserve) {
        $user = new User();

        // パターン１
        $user->plan = 'regular';
        $remainingCount = 1;
        $reservationCount = 4;
        $this->assertTrue($user->canReserve($remainingCount, $reservationCount));

        // パターン２
        $user->plan = 'regular';
        $remainingCount = 1;
        $reservationCount = 5;
        $this->assertFalse($user-> canReservation($remainingCount, $reservationCount));
    }

    public function dataCanReserve() {
        return [
            '予約可:レギュラー,空きあり,月の上限以下' => [
                'plan' => 'regular',
                'remainingCount' => 1,
                'reservationCount' => 4,
                'canReserve' => true,
            ],
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
            '予約可:ゴールド,空きあり' => [
                'plan' => 'gold',
                'remainingCount' => 1,
                'reservationCount' => 5,
                'canReserve' => true,
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
