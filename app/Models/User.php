<?php

namespace App\Models;

use Carvon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reservationCountThisMonth() {
        $today = Carbon::today();
        return $this->reservations()
            ->whereYear('created_at', $today->year)
            ->whereMonth('created_at', $today->month)
            ->count();
    }

    /**
     * @param Lesson $lesson
     * @throws Exception
     */
    public function canReserve(Lesson $lesson): void {
        if ($lesson->remainingCount() === 0) {
            throw new Exception('レッスンの予約可能上限に達しています。');
        }
        if ($this->plan === 'gold') {
            return;
        }
        if ($this->reservationCountThisMonth() === 5) {
            throw new Exception('今月の予約がプランの上限に達しています。');
        }
    }
}
