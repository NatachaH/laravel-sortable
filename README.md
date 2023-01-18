# Installation

Install the package via composer:

```
composer require nh/sortable
```

To make a model with position, you can create a migration via the console commande:

```
php artisan sortable:new {model? : the name of the model}
```

Then, add the **Sortable** trait to your model:
*The default sortable values are position by asc. The trait will add the position column to your $fillable array*

```
use Nh\Sortable\Traits\Sortable;

use Sortable;

/**
 * Default sortable field and direction.
 * @var array
 */
protected $sortable = [
  'field' => 'position',
  'direction' => 'asc'
];

```

In option you can fire an event on the 'parent' model.
Exemple if you sort the Media model in a Page model

```
/**
 * Default sortable field and direction.
 * @var array
 */
protected $sortable = [
  'field' => 'position',
  'direction' => 'asc',
  'event-on-parent' => true,
  'parent' => 'mediable'
];

```

In option you can also update the timestamps or not (updated_at)
By default it set to true

```
/**
 * Default sortable field and direction.
 * @var array
 */
protected $sortable = [
  'field' => 'position',
  'direction' => 'asc',
  'timestamp' => true
];

```

# Javascript & View

Add in your **package.json** the dependency:

```
"sortablejs": "^1.10.2",
```

And add in your JS file the Sortable script:

```
import Sortable from  '../../vendor/nh/sortable/resources/js/sortable';
```

Initialize the Sortable in your JS file.

```
var el = document.querySelector('#mySortable');
new Sortable(el, {
  successCallback: function(response){
      console.log('Position updated !');
  },
  errorCallback: function(response){
      console.log('You got an error');
  }
});
```

Then in your view, add the element:

- On the parent, add the attribute **data-sortable-model**
- On the parent, add the attribute **data-sortable-order** if you need to specify the order to rearanged
- On the children, add the attribute **data-id**
- On the children, add an element with class **.drag**

```
<ul id="mySortable" data-sortable-mode="App\Model" data-sortable-order="desc">
  <li data-id="1"><span class="drag"></span> One</li>
  <li data-id="2"><span class="drag"></span> Two</li>
  <li data-id="3"><span class="drag"></span> Three</li>
</ul>
```

# Get collection by position

You can get your model collection by the position:
*You can pass the direction asc or desc*

```
$model->byPosition()
$model->byPosition('desc')
```

# Get collection by sortable

You can get your model collection by the sortable customer or default:
*The values of your $sortable array will be take as default*

```
$model->sortable()
$model->sortable('name','desc')
```

# Events

You can use the **SortableEvent** for dispatch events that happen where sorted happend.
*You can pass a name, the model, and the number of model affected*

```
SortableEvent::dispatch('my-event', $model, $relation, 1);
```
