/*
|--------------------------------------------------------------------------
| Sortable Script
|--------------------------------------------------------------------------
|
| Copyright © 2020 Natacha Herth, design & web development | https://www.natachaherth.ch/
|
*/

window.SortableJs = require('sortablejs').default;

// DYNAMIC MODULE
(function() {

  // Define the module
  this.Sortable = function(el,options = null) {

      // Variables
      this.el = null;

      // Define option defaults
      var defaults = {
          successCallback: function(e){},
          errorCallback: function(e){}
      };

      // Create options by extending defaults with the passed in arugments
      var customOptions = (options && typeof options === "object" ? options : null );
      this.options = this.setOption(defaults, options);

      // Init variables and number of inputs
      this.el = el ? el : '.sortable';
      this.init();

  }

  //------  METHODS ------//

  // Init
  Sortable.prototype.init = function()
  {

    var sortableObject = this;

    SortableJs.create(this.el, {
       animation: 150,
       handle: '.drag',
       onEnd: function (evt) {
           var url   = '/sortable/update';
           var model = this.el.getAttribute('data-sortable-model');
           var ids   = sortableObject.getIds(this.el.children);
           var order = this.el.getAttribute('data-sortable-order');
           axios({
               method: 'post',
               url: url,
               data: {
                 'model' : model,
                 'ids': ids,
                 'order' : order
               }
           }).then((response)=>{
               sortableObject.options.successCallback(response);
           }).catch((error)=>{
               sortableObject.options.errorCallback(error.response);
           });
       }

    });
  }

  // SetOptions
  Sortable.prototype.setOption = function(source, properties)
  {
      var property;
      for (property in properties) {
        if (properties.hasOwnProperty(property)) {
          source[property] = properties[property];
        }
      }
      return source;
  }

  // Get the ids in the new order
  Sortable.prototype.getIds = function(items) {
      var ids = [];
      Array.prototype.forEach.call(items,function(el, i) {
        if(el.hasAttribute('data-id'))
        {
          var id = el.getAttribute('data-id');
          ids.push(id);
        }
      });
      return ids;
  }

}());
