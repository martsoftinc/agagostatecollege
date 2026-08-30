<?php

namespace App\Helpers;

class GradeHelper
{
    public static function calculate(float $total): array
    {
        return match (true) {
            $total >= 80 => ['grade' => 'A1', 'point' => 4.0],
            $total >= 70 => ['grade' => 'B2', 'point' => 3.5],
            $total >= 60 => ['grade' => 'B3', 'point' => 3.0],
            $total >= 55 => ['grade' => 'C4', 'point' => 2.5],
            $total >= 50 => ['grade' => 'C5', 'point' => 2.0],
            $total >= 45 => ['grade' => 'C6', 'point' => 1.5],
            $total >= 40 => ['grade' => 'D7', 'point' => 1.0],
            $total >= 35 => ['grade' => 'E8', 'point' => 0.5],
            default      => ['grade' => 'F9', 'point' => 0.0],
        };
    }
}