<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\VacancyLevel;

/*
 * @see \App\Models\VacancyLevel
 */
class VacancyLevelTest extends TestCase
{

    /**
     * @test mark
     * @param int $remainingCount
     * @param string $expectedMark
     * @dataProvider dataMark
     */
    public function mark：空き枠数に応じた記号を返す(int $remainingCount, string $expectedMark) {

        // VacancyLevelのmark()メソッドは、コンストラクタで空き枠数を受け取り、枠数に応じた記号を返す
        // 空き0 => ×, 5未満 => △, 5以上 => ◎

        $level = new VacancyLevel($remainingCount);
        $this->assertSame($expectedMark, $level->mark());

    }

    /**
     * @test slug
     * @param int $remainingCount
     * @param string $expectedSlug
     * @dataProvider dataSlug
     */
    public function slug：空き枠数に応じたCSSを適用するためのclass属性名を返す(int $remainingCount, string $expectedSlug) {

        $level = new VacancyLevel($remainingCount);
        $this->assertSame($expectedSlug, $level->slug());
    }

    // PHPUnitには"dataProvider"という機能があり、テストのパターンを配列で定義してテストメソッドに渡すことができる
    public function dataMark() {
        return [
            '空きなし' => [ // キーにテストケースを記述。'空きなし''残りわずか''空き十分'
                // 各テストケースの連想配列のキーはテストメソッドの引数と対応している。書かなくても良いが、書くと対応がわかりやすくなる
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

    public function dataSlug() {
        return [
            '空きなし' => [
                'remainingCount' => 0,
                'expectedMark' =>  'empty',
            ],
            '残りわずか' => [
                'remainingCount' => 4,
                'expectedMark' => 'few',
            ],
            '空き十分' => [
                'remainingCount' => 5,
                'expectedMark' => 'enough',
            ],
        ];
    }
}
