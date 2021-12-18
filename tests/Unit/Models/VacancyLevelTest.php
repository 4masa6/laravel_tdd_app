<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\VacancyLevel;

class VacancyLevelTest extends TestCase
{

    /**
     * @param int $remainingCount
     * @param string $expectedMark
     * @dataProvider dataMark
     */
    public function testMark(int $remainingCount, string $expectedMark) {

        // VacancyLevelのmark()メソッドは、コンストラクタで空き枠数を受け取り、枠数に応じた記号を返す
        // 空き0 => ×, 5未満 => △, 5以上 => ◎

        $level = new VacancyLevel($remainingCount);
        $this->assertSame($expectedMark, $level->mark());

    }

    // PHPUnitには"dataProvider"という機能があり、テストのパターンを配列で定義してテストメソッドに渡すことができる
    // １階層目にはテストケースを記述。'空きなし''残りわずか''空き十分'
    // 各テストケースの連想配列のキーはテストメソッドの引数と対応している。書かなくても良いが、書くと対応がわかりやすくなる
    public function dataMark() {
        return [
            '空きなし' => [
                'remainingCount' => 0,
                'expectedMark' =>  '×',
            ],
            '残りわずか' => [
                'remainingCount' => 4,
                'expectedMark' => '△',
            ],
            '空き十分' => [
                'remainingCount' => 5,
                'expectedMark' => '◎',
            ],
        ];
    }
}
