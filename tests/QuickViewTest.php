<?php

namespace OlegGanshonkov\QuickView\Tests;

use OlegGanshonkov\QuickView\QuickView;
use Faker;
use PHPUnit\Framework\DOMAssert;
use PHPUnit\Framework\TestCase;

class QuickViewTest extends TestCase
{
    public function testUl()
    {
        $myClass = new QuickView();
        $faker = Faker\Factory::create();

        $data = [$faker->name(), $faker->name(), $faker->name()];

        $selector = '.quick-view > li';
        $count = 3;

        DOMAssert::assertSelectCount($selector, $count, $myClass->ul($data));
    }
}
