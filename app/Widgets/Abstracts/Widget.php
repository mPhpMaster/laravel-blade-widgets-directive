<?php

namespace App\Widgets\Abstracts;

use Illuminate\Contracts\Support\Renderable;
use Laravel\Nova\Makeable;

abstract class Widget implements Renderable
{
    use Makeable;

    public static $widgets_namespace = "\\App\\Widgets\\";
    public static bool $active = true;
    /**
     * @var array
     */
    public array $data = [];

    public function __construct($data = [])
    {
        $this->setData($data);
    }

    /**
     * @param array|\Closure|mixed $data
     *
     * @return Widget
     */
    public function setData($data): Widget
    {
        $this->data = (array) value($data);

        return $this;
    }

    public static function getWidget($name, ...$args)
    {
        $widget_class = null;
        $mapWith = [
            [ 'studly_case', "" ],
            [ 'studly_case', "_widget" ],
            [ 'trim', "" ],
            [ 'trim', "_widget" ],
            [ 'camel_case', "" ],
            [ 'camel_case', "_widget" ],
            [ 'snake_case', "" ],
            [ 'snake_case', "_widget" ],
        ];
        foreach( $mapWith as $transformer ) {
            [ $method, $suffix ] = $transformer;
            if( is_callable($method) && class_exists(
                    $_namespace = static::getNamespace($method(trim("{$name}{$suffix}")))
                ) ) {
                $widget_class = $_namespace;
                break;
            }
        }
        /** @var \App\Widgets\Abstracts\Widget $widget_class */
        $widget_class ??= class_exists(trim($name)) ? trim($name) : null;
        throw_if(is_null($widget_class), "Widget [{$name}] not exists!");

        if( !$widget_class::isActive() ) {
            $widget_class = EmptyWidget::class;
        }

        return $widget_class::make(...$args);
    }

    public static function getNamespace($append = "")
    {
        return value(static::$widgets_namespace) . value($append);
    }

    public static function isActive(): bool
    {
        return static::$active;
    }

    public function __toString()
    {
        return (string) $this->render();
    }

    public function setActive($active = true)
    {
        static::$active = (bool) value($active);
        return $this;
    }

    /**
     * Set/Get Data
     *
     * @param mixed ...$args data to set
     *
     * @return array
     */
    public function data(): array
    {
        if( func_num_args() ) {
            $this->setData(...func_get_args());
        }

        return $this->data;
    }
}
