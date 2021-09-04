<?php

namespace Nh\Sortable\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SortableEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Name of the event
     * @var string
     */
    public $name;

    /**
     * The model who has been sorted
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * The number of sorted model affected
     * @var int
     */
    public $number;

    /**
     * Create a new event instance.
     * @param string  $name
     * @param \Illuminate\Database\Eloquent\Model  $model
     */
    public function __construct($name,$model,$number = 1)
    {
          $this->name     = $name;
          $this->model    = $model;
          $this->number   = $number;
    }
}
