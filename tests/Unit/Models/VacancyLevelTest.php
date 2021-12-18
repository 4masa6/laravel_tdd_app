<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\VacancyLevel;

class VacancyLevelTest extends TestCase
{
    public function testMark() {
        
        // VacancyLevelのmark()メソッドは、コンストラクタで空き枠数を受け取り、枠数に応じた記号を返す
        // 空き0 => ×, 5未満 => △, 5以上 => ◎
        
        $level = new VacancyLevel(0);
        $this->assertSame('×', $level->mark());

        // 境界値は4と5になる
        $level = new VacancyLevel(4);
        $this->assertSame('△', $level->mark());

        $level = new VacancyLevel(5);
        $this->assertSame('◎', $level->mark());


    }
}
