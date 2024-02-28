<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TestTypeEnum: int implements HasLabel
{
    case COMPILATION_TEST = 1;
    case FUNCTIONALITY_TEST = 2;
    case CODE_QUALITY_TEST = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::COMPILATION_TEST => 'Compilation Test',
            self::FUNCTIONALITY_TEST => 'Functional Test',
            self::CODE_QUALITY_TEST => 'Code Quality Test',
        };
    }
}