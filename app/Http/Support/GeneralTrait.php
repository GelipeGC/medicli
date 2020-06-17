<?php

namespace App\Http\Support;

use Illuminate\Support\Str;

trait GeneralTrait
{
    /**
     * Change a string is first character uppercase and all string to lower
     */
    public function ucfirst(string $string = null)
    {
        $lower =  Str::lower($string);

        return Str::ucfirst($lower);
    }
    /**
     * Change a string is
     */
    public function initCap(string $string = null)
    {
        $lower = Str::lower($string);
        
        return ucwords($lower);

    }
}