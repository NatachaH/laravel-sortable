<?php
namespace Nh\Sortable\Traits;

use App;
use Illuminate\Database\Eloquent\Builder;

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
}
