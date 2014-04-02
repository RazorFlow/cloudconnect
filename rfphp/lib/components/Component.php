<?php

/**
 * Base Component Class
 * @class Component
 * @access private
 */
abstract class Component {

    /**
     * Set the caption of this component which is the text displayed on top of the component
     * @method setCaption
     * @param {String} $caption         Caption text to be displayed on the component
     */
    public function setCaption ($caption) {
        $this->props->setValue ('core.caption', $caption);
    }

    /**
     * Set the dimensions of the component. The dimensions are based on a 12-column grid
     * @method setDimensions
     * @param {Number} $w        Width of the Component in Units
     * @param {Number} $h        Height of the Component in Units
     */
    public function setDimensions ($w, $h) {
        $this->provide('dimensions');
        $this->props->setObjectAtPath ('core.location', array(
            'x' => 0,
            'y' => 0,
            'w' => $w,
            'h' => $h
        ));
    }

    protected $aspects = array();

    protected function provide ($aspectName) {
        $this->aspects[$aspectName] = true;
    }

    protected function requireAspects ($object) {
        foreach ($object as $key => $value) {
            if(!isset($this->aspects[$key])) {
                throw new Exception ($value);
            }
        }
    }

    protected function validate () {
      $this->requireAspects(array(
        "dimensions" => "Please provide dimensions using setDimensions"
      ));
    }

    public function bindToEvent ($eventName, $components, $target) {
        $componentIds = array();
        foreach($components as $c) {
            $componentIds []= array('id' => $c->getID());
        }

        $eventProperties = array(
            'type' => $eventName,
            'affectedComponents' => $componentIds,
            'url' => RFUtil::buildURL($this->getBasePath (), array('action' => 'triggerAction', 'func' => $target))
        );

        $this->props->pushItemToList("events", $eventProperties);
    }

    public function getBasePath () {
        return $_SERVER['REQUEST_URI'];
    }

    protected $id;
    /**
     * @var PropertyBase
     */
    protected $props;

    /**
     * @var DataSource
     */
    protected $data;

    protected $dirty = false;

    protected $patches = array();
    protected $dpatches = array();


    function __construct($id) {
        $this->id = $id;
        $this->data = new DataSource();
        $this->data->linkToComponent($this);
    }

    /**
     * Get the id for this component 
     * @method getID
     */
    public function getID () {
        return $this->id;
    }

    public function getAsObject () {
        $this->validate();
        return array(
            'type' => $this->getType (),
            'props' => $this->props->getRootObject(),
            'data' => $this->data->getRaw()
        );
    }

    public function getType () {
        return "Component";
    }

    public function __flagDirty () {
        $this->dirty = true;
    }

    public function __buildFromObject ($obj) {
        $this->props->setRootObject ($obj['props']);
    }

    public function __getPatches () {
        return array(
            'props' => $this->patches,
            'data' => $this->dpatches
        );
    }

    public function postInit () {
        $this->props->setBasePath ("");
    }

    public function __addPatch ($action, $path, $params) {
        if($this->dirty) {
            $this->patches []= array(
                'action' => $action,
                'path' => $path,
                'params' => $params
            );
        }
    }

    public function __addDPatch ($action, $index, $params) {
        if ($this->dirty ) {
            $this->dpatches []= array(
                'action' => $action,
                'index' => $index,
                'params' => $params
            );
        }
    }

    public function initialize () {
        // DO nothing by default
    }
        
}
