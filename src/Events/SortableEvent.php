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
     * The model or the parent model
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * The model or null
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $relation;

    /**
     * The number of sorted model affected
     * @var int
     */
    public $number;


    /**
     * Create a new event instance.
     * @param string  $name
     * @param \Illuminate\Database\Eloquent\Model  $model
     * @param \Illuminate\Database\Eloquent\Model $relation
     * @param int  $number
     */
    public function __construct($name,$model,$relation = null,$number = null)
    {
        $this->name     = $name;
        $this->model    = $model;
        $this->relation = $relation;
        $this->number   = $number;
    }
}
