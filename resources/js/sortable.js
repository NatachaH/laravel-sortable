/*
|--------------------------------------------------------------------------
| Sortable Script
|--------------------------------------------------------------------------
|
| Copyright © 2023 Natacha Herth, design & web development | https://www.natachaherth.ch/
| Plugin: SortableJS - https://github.com/SortableJS/Sortable
|
*/

import SortableJs from 'sortablejs';


export default class Sortable {

  /**
   * Creates an instance
   *
   * @author: Natacha Herth
   * @param {object} el The element
   * @param {object} options Options that you can overide
   */
  constructor(el,options = null){

    // Get the element
    this.el = el;

    // Get the parent
    this.parent = el.parentNode;

    // Get the SortableJS object
    this.sortable = null;

    // Create options by extending defaults with the passed in arugments
    this.options = this.setOptions(options);

    // Init the ToggleSwitch
    this.init();

  }

  /**
   * Set the options
   *
   * @param {object} options Option that you want to overide
   * @return {object} The new option object.
   */
  setOptions(options) {

    // Variables that you can set as options
    const defaultOptions = {
      successCallback(e){}, // Callback function
      errorCallback(e){} // Callback function
    }

    // Update the options
    for (let option in options) {
      if (options.hasOwnProperty(option)) {
        defaultOptions[option] = options[option];
      }
    }

    // Return the object
    return defaultOptions;

  }

  /**
   * Init the Sortable
   */
  init() {

    const that = this;

    this.sortable = SortableJs.create(this.el, {
      animation: 150,
      handle: '.drag',
      onEnd: function (evt) {
          var url   = '/sortable/update';
          var model = this.el.getAttribute('data-sortable-model');
          var ids   = that.getIds(this.el.children);
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
            that.options.successCallback(response);
          }).catch((error)=>{
            that.options.errorCallback(error.response);
          });
      }

   });

  }

  /**
   * Get the ids
   * @param {array} items 
   * @returns {array}
   */
  getIds(items) {

    let ids = [];

    Array.from(items).forEach(el => {
      if(el.hasAttribute('data-id'))
      {
        var id = el.getAttribute('data-id');
        ids.push(id);
      }
    });
   
    return ids;

  }



}