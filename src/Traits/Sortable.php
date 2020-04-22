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
        $this->fillable[] = 'position';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    protected static function bootSortable()
    {
        // After an item is saved
        static::creating(function ($model)
        {
            $model->setNextPositionNumber();
        });

    }

    /**
     * Get model by position
     * @param  Builder $query
     * @param  string  $direction
     * @return Builder $query
     */
    public static function scopeByPosition(Builder $query, string $direction = 'asc')
    {
        return $query->orderBy('position',$direction);
    }

    /**
     * Set the next position for a new model
     */
    private function setNextPositionNumber()
    {
        $this->position = static::query()->max('position') + 1;
    }
}
