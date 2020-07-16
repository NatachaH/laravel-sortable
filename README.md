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

```
use Nh\Sortable\Traits\Sortable;

use Sortable;
```

# Javascript & View

Add in your **package.json** the dependency:

```
"sortablejs": "^1.10.2",
```

And add in your JS file the Sortable script:

```
require('../../vendor/nh/sortable/resources/js/sortable');
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
$model->ByPosition()
$model->ByPosition('desc')
```
