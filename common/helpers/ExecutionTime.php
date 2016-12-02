<?php
namespace common\helpers;

class ExecutionTime
{
    private static $startTime;
    private static $endTime;

    public static function start()
    {
        self::$startTime = microtime(true);
    }

    public static function end()
    {
        self::$endTime = microtime(true);
    }

    public static function printResult()
    {
        $executionTime = self::$endTime - self::$startTime;
        print PHP_EOL . "Execution time: " . round($executionTime, 2) . ' seconds' . PHP_EOL;
    }
}