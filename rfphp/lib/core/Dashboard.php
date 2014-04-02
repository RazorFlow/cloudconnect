<?php

abstract class Dashboard {

    public function __construct(){
      global $_rfConfig;
      if(isset($_rfConfig['staticRoot'])){
        $this->staticRoot = $_rfConfig['staticRoot'];
      }
    }

    public function setStaticRoot($staticRoot) {
        $this->staticRoot = $staticRoot;
    }
    public function getStaticRoot() {
        return $this->staticRoot;
    }

    protected $properties = array();

    /**
     * @param $component Component
     */
    public function addComponent ($component) {
        $this->components []= $component;
        $this->componentById [$component->getID()] = $component;
    }

    public function setDashboardTitle ($title) {
        $this->properties['dashboardTitle'] = $title;
    }

    public function getComponentByID ($id) {
        if(!isset($this->componentById[$id])) {
            die("Cannot find component with id $id");
        }
        return $this->componentById[$id];
    }

    protected function getAsObject () {
        $result = array('components' => array(), 'properties' => $this->properties);

        /** @var $c Component */
        foreach($this->components as $c) {
            $c->initialize();
            $result['components'][$c->getID()] = $c->getAsObject();
        }

        return $result;
    }

    protected function handleAction () {
        $func = $_GET['func'];
        
        if(method_exists($this, $func)) {
            $params = array();
            if(isset($_POST['params'])) {
                $params = json_decode($_POST['params'], true);
            }

            // parse the postback
            $this->parsePostback ($_POST['postback']);

            // Initialize the dashboard members, etc
            $this->initialize ();

            // Execute the function
            $this->$func(null, null, $params);

            // Push the updates as json
            $this->renderUpdates();
        }
    }

    protected function parsePostback ($postbackString) {
        $pb = json_decode($postbackString, true);
        
        foreach ($pb['components'] as $key => $value) {
            $cobj = null;
            
            switch ($value['type']) {
                case 'KPIComponent':
                    $cobj = new KPIComponent ($key);
                    break;
                case 'TableComponent':
                    $cobj = new TableComponent ($key);
                    break;
                case 'ChartComponent':
                    $cobj = new ChartComponent ($key);
                    break;
                default:
                    die("Unknown component type");
                    break;
            }
            
            $cobj->__buildFromObject ($value);
            $cobj->__flagDirty();
            
            $this->addComponent ($cobj);
        }
    }

    protected function extractAction () {
        if(isset($_GET['action'])) {
            return $_GET['action'];
        }
        return null;
    }

    protected function shouldRenderDashboard () {

        $action = $this->extractAction();
        if($action === "triggerAction") {
            $this->handleAction ();
            return false;
        }
        return true;
    }

    protected function getDispatchObject () {
        $resp = array(
            'patches' => array()
        );
        foreach ($this->componentById as $key => $value) {
            $resp['patches'][$key] = $value->__getPatches ();
        }
        
        return $resp;
    }

    public function RenderUpdates () {
        header ('Content-Type: application/json');
        echo json_encode ($this->getDispatchObject(), JSON_PRETTY_PRINT);
    }

    protected function initialize () {

    }

    protected $staticRoot = "";
    protected $components = array();
    protected $componentById = array();

}
