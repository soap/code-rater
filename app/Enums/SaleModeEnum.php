<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SaleModeEnum: int implements HasLabel
{
    case SUBSCRIPTION = 1;
    case ONETIME = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUBSCRIPTION => 'Subscription',
            self::ONETIME => 'One Time',
        };
    }
}