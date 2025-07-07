<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected int | string | array $columnSpan = 'full';
    protected function getColumns(): int | string | array
    {
        return 1; // 1 kolom penuh
    }

    protected static string $view = 'filament.widgets.welcome-widget';
}
