<?php

namespace App\Widgets;

class ExampleWidget extends \App\Widgets\Abstracts\Widget
{
    public static bool $active = true;

    public function render()
    {
        return "This is Example widget!";
    }
}
