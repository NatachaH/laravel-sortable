<?php
namespace Nh\Sortable\Traits;

use App;
use Illuminate\Database\Eloquent\Builder;
use Nh\Sortable\Events\SortableEvent;

trait Sortable
{
    /**
     * Initialize the sortable.
     * @return void
     */
    public function initializeSortable()
    {

        if(!array_key_exists('direction',$this->sortable))
        {
            $this->sortable['direction'] = 'asc';
        }

        if(!array_key_exists('timestamp',$this->sortable))
        {
            $this->sortable['timestamp'] = true;
        }

        if(!array_key_exists('field',$this->sortable))
        {
            $this->fillable[] = 'position';
            $this->sortable['field'] = 'position';
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    protected static function bootSortable()
    {
        // After an item is saved, if position is null set the next number
        static::creating(function ($model)
        {
            if($model->sortable['field'] == 'position' && is_null($model->position))
            {
              $model->setNextPositionNumber();
            }
        });

    }

    /**
     * Scope a query by position.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string $field
     * @param  string $direction
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPosition(Builder $query, string $direction = 'asc')
    {
        return $query->orderBy('position', $direction);
    }

    /**
     * Scope a query by custome/default sortable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string $field
     * @param  string $direction
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortable(Builder $query, string $field = null, string $direction = null)
    {
        $field = $field ?? $this->sortable['field'];
        $direction = $direction ?? $this->sortable['direction'];
        $direction = in_array($direction, ['asc','desc']) ? $direction : 'asc';
        return $query->orderBy($field, $direction);
    }

    /**
     * Set the next position for a new model
     */
    private function setNextPositionNumber()
    {
        $this->position = static::query()->max('position') + 1;
    }

    /**
     * Update the position and check if it required the timestamp update
     * @param  int $number
     */
    public function updatePosition(int $number)
    {
        $this->timestamps = $this->sortable['timestamp'];
        $this->position = $number;
        $this->save();
    }

    /**
     * Fire the SortableEvent on model or on his parent
     * @param  array $ids_updated
     * @return void
     */
    public function fireSortedEvent($ids_updated)
    {
        // Get the number of model affected
        $nbr = count($ids_updated);

        if(array_key_exists('event-on-parent',$this->sortable) && array_key_exists('parent',$this->sortable) && $this->sortable['event-on-parent'])
        {
            // If the model should fire event on parent model
            $model    = $this->firstWhere('id',$ids_updated[0]);
            $parent   = $model[$this->sortable['parent']];
            $relation = $this;

            // Event set on parent
            SortableEvent::dispatch('sorted', $parent, $relation, $nbr);
        } else {
            // Event set on model
            SortableEvent::dispatch('sorted', $this, null, $nbr);
        }
    }
}
