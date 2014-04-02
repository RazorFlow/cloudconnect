<?php

/**
 * Creates a chart component which has a chart
 * @class ChartComponent
 * @augments {Component}
 */
class ChartComponent extends Component {
	public function __construct ($id) {
        parent::__construct ($id);

        $this->props = new ChartComponentProperties ();
        $this->props->linkToComponent ($this);

        $this->postInit();
    }
    /**
     * Adds a series to the chart. The number of data points provided using the seriesData array should be the same as the other series and the number of labels 
     * @method addSeries
     * @param {String} $id          Unique id of the series. This will be used for updating the series data
     * @param {String} $name        The name of this series
     * @param {Array}  $seriesData  The series data
     * @param {Array}  $opts        A bunch of options passed to as an associative array
     * @example
     * $chart1 = new ChartComponent('my_chart1');
     * $chart1->addSeries('sales', 'Sales', array(826.25, 382.14, 261.36, 241.56, 93.53, 79.20, 60.39, 57.71, 40.59, 40.59));
     */
    public function addSeries ($id, $name, $seriesData, $opts = array())
    {
        $this->provide('series');
        $opts['seriesName'] = $name;
        $this->props->addItemToList('chart.series', $id, $opts);
        $this->data->addColumn($id, $seriesData);
    }

    /**
     * Set an array of data points which will be used for the pie chart
     * @method setPieValues
     * @param {Array} $seriesData   The series data array
     * @param {Array}  $opts        The series options as an associative array
     */
    public function setPieValues ($seriesData, $opts = array()) {
        $opts['seriesDisplayType'] = 'pie';
        $this->addSeries('pie0', 'Pie', $seriesData, $opts);
    }

    /**
     * Updates a series
     * @method updateSeries
     * @param  {String} $id       The id of the series
     * @param  {Array} $newData   The update data array
     */
    public function updateSeries ($id, $newData) {
        $this->data->addColumn($id, $newData);
    }

    /**
     * Set the labels of the chart, which are the names on the X-Axis
     * @method setLables
     * @param {Array} $labelArray An array of labels as strings
     */
    public function setLabels ($labelArray) {
        $this->provide('labels');
        $this->data->addColumn('rfLabels', $labelArray);
	}

    protected function validate () {
        parent::validate();
        $this->requireAspects (array(
            'series' => "Please add a series using addSeries",
            'labels' => "Please set some labels using addLabels"
        ));
    }

    /**
     * Configure the Y-Axis of the chart
     * @method setYAxis
     * @param {String} $name      The name of the y axis
     * @param {Array}  $options   Options array. See the guide for available options
     */
    public function setYAxis ($name, $options = array()) {
        $options['axisName'] = $name;
        $this->props->setObjectAtPath('chart.yaxis', $options);
    }

    /**
    * Attach a handler for the event when a chart plot item is clicked
    * @method onItemClick
    * @param {Array} $lockedComponents           Components to be locked
    * @param {String} $func                      Function name to be executed on item click
    */

    public function onItemClick ($lockedComponents, $func){
      $this->bindToEvent ("itemClick", $lockedComponents, $func);
    }

    public function clearChart () {
        $this->data->clearRows ();
        $this->props->emptyList ("chart.series");
    }

    /**
     * Gets the type of this component
     * @method getType
     * @return {String} The component type
     */
    public function getType () {
        return "ChartComponent";
    }
} 
