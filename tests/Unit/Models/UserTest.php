<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @test canReserve
     */
    public function ユーザーが正常に予約できる() {
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
}
