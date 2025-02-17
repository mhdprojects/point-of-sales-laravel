<?php

namespace App\Helper;

use Illuminate\Support\Str;

class Utils{

    public static function toSelect($value, $label): array{
        return [
            'value' => $value,
            'label' => $label
        ];
    }

    public static function generateCode(): string{

        return date('ymd').Str::random(6);
    }
}
