<?php

namespace App\Widgets\Abstracts;

class EmptyWidget extends \App\Widgets\Abstracts\Widget
{
    public static bool $active = true;

    public function render()
    {
        return "";
    }
}
