<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function getVacancyLevelAttribute() {
        return new VacancyLevel($this->remainingCount());
    }

    private function remainingCount() {
        return 0;
    }
}
