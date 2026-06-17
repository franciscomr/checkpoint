<?php

namespace App\Modules\Assets\Services;

class AssetTagGenerator
{
    public function generate(): string
    {
        return sprintf(
            'AST-%06d',
            random_int(1, 999999)
        );
    }
}
