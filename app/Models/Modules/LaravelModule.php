<?php

namespace Gameap\Models\Modules;

class LaravelModule
{
    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $description;

    /** @var string[] */
    public $tags;

    /** @var bool */
    public $isEnabled;
}
