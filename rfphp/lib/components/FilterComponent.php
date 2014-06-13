<?php

/**
 * Creates a Filter Component
 * @class FilterComponent
 * @param {String} $id     uniquely identifies the instance of this class   
 * @augments {Component}
 */
class FilterComponent extends RFComponent {

  function __construct ($id) {
      parent::__construct ($id);

      $this->props = new FilterComponentProperties();
      $this->props->linkToComponent ($this);

      $this->postInit();
  }

  /**
    * Add a text filter represented by a HTML Text input on the filter form
    * @method addTextFilter
    * @param {String} $id            Id for this filter item used to retrieve the value
    * @param {String} $label         The label that is displayed in the form element for the user
    * @param {Array} $options       The options as an associative array
    */
  public function addTextFilter ($id, $label, $options = array()) {
    $opts = array();
    $opts['type'] = 'text';
    $opts['label'] = $label;
    $opts['options'] = $options;

    $this->props->addItemToList("filter.items", $id, $opts);
  }

  /**
    * Add a select/dropdown filter which allows the user to select one option from a list of pre-defined options. This is displayed as a HTML Select input on the filter form
    * @method addSelectFilter
    * @param {String} $id           Id for this filter item used to retrieve the value
    * @param {String} $label        The label that is displayed in the form element for the user
    * @param {Array} $list          An array of strings which are the options in the select items
    * @param {Array} $options       The options as an associative array
    */
  public function addSelectFilter ($id, $label, $list, $options=array()){
    $opts = array();
    $opts['type'] = 'select';
    $opts['label'] = $label;
    $opts['list'] = $list;
    $opts['options'] = $options;

    $this->props->addItemToList("filter.items", $id, $opts);
  }

  /**
    * Add a multi-select filter which allows the user to select one option from a list of pre-defined options. This is displayed as a HTML multi select input on the filter form
    * @method addMultiSelectFilter
    * @param {String} $id             Id for this filter item used to retrieve the value
    * @param {String} $label          The label that is displayed in the form element for the user
    * @param {Array} $list            An array of strings which are the options in the select items
    * @param {Array} $options         The options as an associative array
    */
  public function addMultiSelectFilter ($id, $label, $list, $options=array()) {
    $opts = array();
    if(!isset($options['defaultSelectedOptions'])) {
      $options['defaultSelectedOptions'] = array();
    }
    $opts['type'] = 'multiSelect';
    $opts['label'] = $label;
    $opts['list'] = $list;
    $opts['options'] = $options;

    $this->props->addItemToList("filter.items", $id, $opts);
  }

  /**
    * Add a select/dropdown filter which allows the user to select a single date. This is displayed with a date picker.
    * @method addDateFilter
    * @param {String} $id           Id for this filter item used to retrieve the value
    * @param {String} $label        The label that is displayed in the form element for the user
    * @param {Array} $options       The options as an associative array
    */
  public function addDateFilter ($id, $label, $options=array()) {
    $opts = array();
    $opts['type'] = 'date';
    $opts['label'] = $label;
    $opts['options'] = $options;

    $this->props->addItemToList("filter.items", $id, $opts);
  }

  /**
    * Adds a Date Range filter to the component. This filter can be used to select a date range, a start date and an end date.
    * @method addDateRangeFilter
    * @param {String} $id           Id for this filter item used to retrieve the value
    * @param {String} $label        The label that is displayed in the form element for the user
    * @param {Array} $options       The options as an associative array
    */
  public function addDateRangeFilter ($id, $label, $options=array()) {
    $opts = array();
    $opts['type'] = 'dateRange';
    $opts['label'] = $label;
    $opts['options'] = $options;

    $this->props->addItemToList("filter.items", $id, $opts);
  }

  /**
    * Adds a Numeric Range filter to the component. This filter can be used to select a numeric range, a start number and an end number.
    * @method addNumericRangeFilter
    * @param {String} $id           Unique id for this filter
    * @param {String} $label        The name displayed on the control
    * @param {Array} $values        The default values for the start and end numbers
    * @param {Array} $options       Array of options
    */
  public function addNumericRangeFilter ($id, $label, $values, $options=array()) {
    $opts = array();
    $opts['type'] = 'numericRange';
    $opts['label'] = $label;
    $opts['options']['values'] = $values;

    $this->props->addItemToList("filter.items", $id, $opts);
  }

  /**
    * Add a checkbox filter displayed as a HTML checkbox in the form.
    * @method addCheckboxFilter
    * @param {String} $id           Id for this filter item used to retrieve the value
    * @param {String} $label        The label that is displayed in the form element for the user
    * @param {Boolean} $value       If the checkbox is supposed to be checked by default
    */
  public function addCheckboxFilter ($id, $label, $value) {
    $opts = array();
    $opts['type'] = 'checkbox';
    $opts['label'] = $label;
    $opts['options'] = array('value' => $value);

    $this->props->addItemToList("filter.items", $id, $opts);
  }

  /**
    * Adds an on apply click handler
    * @method onApplyClick
    * @param {Array} $lockedComponents           Components to be locked
    * @param {String} $func                      Function name to be executed on apply filter
    */

  public function onApplyClick ($lockedComponents, $func, $db){
    $this->bindToEvent ("submit", $lockedComponents, $func, $db);
  }

  /**
    * Get all the input values
    * @method getAllInputValues
    */

  public function getAllInputValues() {
    return $this->inputValues;
  }

  /**
    * Get input value by id
    * @method getInputValue
    * @param {String} $id       The id of a specific filter item
    */

  public function getInputValue($id) {
    return $this->inputValues[$id];
  }

  /**
    * Gets the type of this component
    * @method getType
    * @return {String} The component type
    */
  public function getType () {
      return "FilterComponent";
  }

  public function setInputValues($values) {
    $this->inputValues = $values;
  }

  protected function validate (){
    if($this->isHidden()) {
      return;
    }
    
    parent::validate();
  }

  private $inputValues;

} 
