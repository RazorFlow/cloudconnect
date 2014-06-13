<?php

abstract class Dashboard {

    public function __construct($id=null){
      global $_rfConfig;

      if($id == null){
        if(!isset($GLOBALS["__rf_dashboard_autoid"])) {
          $GLOBALS["__rf_dashboard_autoid"] = 0;
        }
        $GLOBALS["__rf_dashboard_autoid"] ++;
        $id = "dashboard_".$GLOBALS["__rf_dashboard_autoid"];
      }

      $this->setID($id);

      if(isset($_rfConfig['staticRoot'])){
        $this->staticRoot = $_rfConfig['staticRoot'];
      }

      if(isset($_rfConfig['rfDebug'])) {
        $this->debugMode = $_rfConfig['rfDebug'];
      }
    }

    public function setID ($id) {
      $this->id = $id;
    }

    public function getID(){
      return $this->id;
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
        $component->setDashboard($this);
    }

    public function setDashboardTitle ($title) {
        $this->properties['dashboardTitle'] = $title;
    }

    public function setWidth ($width) {
      $this->properties['dashboardWidth'] = $width;
    }

    public function setHeight ($height) {
      $this->properties['dashboardHeight'] = $height;
    }

    public function setActive () {
      $this->properties['active'] = true;
    }

    public function getComponentByID ($id) {
        if(!isset($this->componentById[$id])) {
            die("Cannot find component with id $id");
        }
        return $this->componentById[$id];
    }

    public function getAsObject () {
        $result = array('components' => array(), 'properties' => $this->properties);

        if($this->getDebugMode()) {
            $result['logs'] = $this->getLogs();
        }

        /** @var $c Component */
        foreach($this->components as $c) {
            $c->initialize();
            $result['components'][$c->getID()] = $c->getAsObject();
        }

        return $result;
    }

    public function getJSONForAction () {
        $func = $_GET['func'];
        $action = $_GET['action'];
        
        if(method_exists($this, $func)) {
            $params = array();
            if(isset($_POST['params'])) {
                $params = json_decode($_POST['params'], true);
            }

            if($action === 'triggerAction') {
              // parse the postback
              $this->parsePostback ($_POST['postback'], $params);
              // Initialize the dashboard members, etc
              $this->initialize ();
            }
            else {
              $this->buildDashboard();
            }


            // Execute the function
            $response = $this->$func(null, null, $params);

            // Push the updates as json
            return ( $action === "triggerAction" ? $this->renderUpdates() : $this->setNewData($response) );
        }
    }

    private function setNewData($data) {
      $component = $this->getComponentByID($_GET['component']);
      return json_encode(array(
        "data" => $component->getUpdatedDataJSON($data),
        "logs" => $this->getLogs()
      ));
    }

    protected $actionPath = null;
    public function getBasePath () {
        if(isset($this->actionPath)) {
            return $this->actionPath;
        }
        return $_SERVER['REQUEST_URI'];
    }

    public function setActionPath ($actionPath) {
      $this->actionPath = $actionPath;
    }


    public function handleAction () {
        if($this->getDebugMode()) {
            set_error_handler(array('RFError', 'error'), E_ALL);
        }
        
        header ('Content-Type: application/json');
        echo $this->getJSONForAction();
        exit();
    }

    public function log($message, $object=null) {
      $this->logs []= array(
        'message' => $message,
        'log' => print_r($object, true)
      );
    }

    protected function parsePostback ($postbackString, $params) {
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
                case 'FilterComponent':
                    $cobj = new FilterComponent($key);
                    $cobj->setInputValues($params);
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
        if($action === "triggerAction" || $action === "getData") {
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

        if($this->getDebugMode()) {
            $resp['logs'] = $this->getLogs();
        }
        
        return $resp;
    }

    public function RenderUpdates () {
        return json_encode ($this->getDispatchObject(), JSON_PRETTY_PRINT);
    }

    protected function initialize () {

    }

    protected function getLogs() {
        return $this->logs;
        // return array(
        //     'dashboard' => $this->getID(),
        //     'logs' => $this->logs
        // );
    }

    public function getDebugMode() {
        return $this->debugMode;
    }

    private $debugMode;
    protected $id;
    protected $staticRoot = "";
    protected $components = array();
    protected $componentById = array();
    protected $logs = array();

}
