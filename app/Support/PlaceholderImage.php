<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlaceholderImage
{
    protected static array $palette = [
        '#2f4d3f',
        '#bf6b45',
        '#3a5a80',
        '#9c844c',
        '#7a4f68',
        '#3f6e5e',
    ];

    public static function generateAndStore(string $label): string
    {
        $width = 800;
        $height = 600;
        $color = static::$palette[array_rand(static::$palette)];
        $text = e(mb_strtoupper(Str::limit($label, 28, '')));

        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="{$height}">
            <rect width="100%" height="100%" fill="{$color}"/>
            <text x="50%" y="50%" font-family="Georgia, serif" font-size="40" fill="#f4f1e9" text-anchor="middle" dominant-baseline="middle">{$text}</text>
        </svg>
        SVG;

        $path = 'properties/'.Str::uuid().'.svg';
        Storage::disk('public')->put($path, $svg);

        return $path;
    }
}
