<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Facadeやconfigファイルを読み込んでいる。⇒ Tests/TestCaseを継承することでLaravelの内部の機能にアクセスできるようになる。
    use CreatesApplication;
}
