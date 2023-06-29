<?php

use Faker\Factory;

class Translator
{
    use SingletonTrait;

    /**
     * @todo: DON'T MODIFY THIS METHOD
     */
    public function translate($language, $str)
    {
        $faker = Factory::create();

        return $faker->words();
    }
}