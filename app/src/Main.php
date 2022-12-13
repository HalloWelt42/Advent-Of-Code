<?php

namespace aoc;

use aoc\advent_of_code\AoC;
use Closure;

require_once __DIR__ . '/../vendor/autoload.php';

class Main
{
    /**
     * @var Closure[]
     */
    private array $container;


    /**
     * all codes ready fpr php 8.1
     *
     * 1. step: change dir to [your project dir]/Advent-Of-Code/app/src/'
     * 2. step: puzzles to run as cli command (example):
     *
     *  php index.php y2022/day_7
     *
     * .. with example testdata:
     *
     *  php index.php y2022/day_7 test
     *
     *
     */
    public function __construct()
    {

        // puzzle register
        $this->add_puzzle('y2022/day_7', \aoc\advent_of_code\y2022\day_7\NoSpaceLeftOnDevice::class);
        $this->add_puzzle('y2022/day_8', \aoc\advent_of_code\y2022\day_8\TreetopTreeHouse::class);


        // read cli arguments
        $test = false;
        if($arg = $_SERVER['argv'][2] ?? false){
            $test = $arg === 'test';
        }
        $current_puzzle = $_SERVER['argv'][1];

        // chk register
        if(array_key_exists($current_puzzle,$this->container) === false){
            echo 'this puzzle is not available' . PHP_EOL;
            exit();
        }
        // call register
        /**
         * @var $instance AoC
         */
        $instance = $this->container[$current_puzzle]($test);

        // puzzle result
        print_r($instance->PartOne() . PHP_EOL);
        print_r($instance->PartTow() . PHP_EOL);

    }

    /**
     * @param string $name
     * @param string $class_name
     * @return void
     */
    private function add_puzzle(string $name, string $class_name): void
    {
        $this->container[$name] = static function (bool $test) use ($class_name, $name) : AoC {
            $input_file = __DIR__ . "/advent_of_code/{$name}/" . ($test ? 'test_' : '') . "input.txt";
            return new $class_name($input_file);
        };
    }

}


new Main();



