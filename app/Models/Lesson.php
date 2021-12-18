<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function getVacancyLevelAttribute() {
        return new VacancyLevel($this->remainingCount());
    }

    private function remainingCount() {
        return 0;
    }
}
