/*
|--------------------------------------------------------------------------
| Sortable Script
|--------------------------------------------------------------------------
|
| Copyright © 2020 Natacha Herth, design & web development | https://www.natachaherth.ch/
| Plugin: SortableJS - https://github.com/SortableJS/Sortable
|
*/

// Library
import Sortable from 'sortablejs';

// Get all .sortable
var sortable = document.querySelectorAll('.sortable');

// Init the Sortable to each .sortable
Array.prototype.forEach.call(sortable, function(el, i) {
   Sortable.create(el, {
      animation: 150,
      handle: '.drag',
      onEnd: function (evt) {
          var url   = '/sortable/update';
          var model = el.getAttribute('data-sortable-model');
          var ids   = getIds(el.children);
          axios({
              method: 'post',
              url: url,
              data: {
                'model' : model,
                'ids': ids
              }
          }).then((response)=>{
              if(sortableSuccessCallback === 'function') sortableSuccessCallback(response);
          }).catch((error)=>{
              if(sortableErrorCallback === 'function') sortableErrorCallback(response);
          });
      }

    });
});

// Get all ids
function getIds(items){
  var ids = [];
  Array.prototype.forEach.call(items, function(el, i) {
    var id = el.getAttribute('data-id');
    ids.push(id);
  });
  return ids;
}
