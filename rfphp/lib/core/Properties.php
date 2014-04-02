<?php
class NullProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(

		));
	}
}
class DataColumnProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'dataType' => "auto",
			'numberFormatFlag' => true,
			'numberHumanize' => false,
			'numberPrefix' => null,
			'numberSuffix' => null,
			'numberThousandsSeparator' => ",",
			'numberDecimalsSeparator' => ".",
			'numberForceDecimals' => false,
			'numberDecimalPoints' => 2
		));
	}
}
class ComponentProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'core' => new ComponentCoreProperties(),
			'events' => new PropertyList('ComponentEventProperties'),
			'children' => new PropertyList('NullProperties'),
			'data' => new ComponentDataProperties()
		));
	}
}
class ComponentDataProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(

		));
	}
}
class TableDataProperties extends ComponentDataProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'rowDataSource' => new RemoteDataSource()
		));
	}
}
class RemoteDataSource extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'url' => null
		));
	}
}
class ComponentEventProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'type' => "",
			'affectedComponents' => new PropertyList('AffectedComponentProperties'),
			'url' => ""
		));
	}
}
class AffectedComponentProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'id' => null
		));
	}
}
class ComponentCoreProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'caption' => "",
			'absolutePosition' => false,
			'dimensions' => new ComponentDimensionProperties(),
			'isChild' => false,
			'location' => new ComponentLocationProperties(),
			'zoomable' => true
		));
	}
}
class ComponentDimensionProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'w' => null,
			'h' => null
		));
	}
}
class ComponentLocationProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'x' => null,
			'y' => null,
			'w' => null,
			'h' => null
		));
	}
}
class KPIComponentProperties extends ComponentProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'kpi' => new KPIProperties()
		));
	}
}
class KPIProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'display' => new KPIDisplayProperties()
		));
	}
}
class KPIDisplayProperties extends DataColumnProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'dataType' => "number",
			'value' => 0,
			'indicator' => null,
			'indicatorColor' => "green",
			'caption' => "",
			'subcaption' => "",
			'target' => null,
			'gaugeType' => "circular",
			'gaugeFlag' => false,
			'sparkFlag' => false,
			'ranges' => new PropertyList('RFRangeProperties'),
			'maximum' => null,
			'minimum' => null,
			'type' => null
		));
	}
}
class RFRangeProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'start' => null,
			'end' => null,
			'color' => null
		));
	}
}
class ChartComponentProperties extends ComponentProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'chart' => new ChartProperties()
		));
	}
}
class ChartProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'series' => new PropertyList('ChartSeriesProperties'),
			'yaxis' => new ChartAxisProperties(),
			'showLegendFlag' => true
		));
	}
}
class ChartAxisProperties extends DataColumnProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'dataType' => "number",
			'axisName' => "",
			'minValue' => null,
			'maxValue' => null,
			'adaptiveMinimumValueFlag' => false
		));
	}
}
class ChartSeriesProperties extends DataColumnProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'dataType' => "number",
			'seriesName' => "",
			'seriesDisplayType' => "column",
			'seriesColor' => "auto",
			'seriesHiddenFlag' => false,
			'includeInLegendFlag' => true
		));
	}
}
class GaugeComponentProperties extends ComponentProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'gauge' => new GaugeProperties()
		));
	}
}
class GaugeProperties extends DataColumnProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'caption' => "",
			'subcaption' => "",
			'min' => 0,
			'max' => 100,
			'value' => 50
		));
	}
}
class TableComponentProperties extends ComponentProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'table' => new TableProperties(),
			'data' => new TableDataProperties()
		));
	}
}
class TableProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'columns' => new PropertyList('TableColumnProperties'),
			'rowsPerPage' => 10,
			'currentPageNumber' => 0,
			'serverPaginationFlag' => false,
			'useRemoteDataSourceFlag' => false,
			'detailViewFlag' => false
		));
	}
}
class TableColumnProperties extends DataColumnProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'name' => "",
			'columnType' => "text",
			'sortable' => false,
			'sortActiveFlag' => false,
			'sortDirection' => "descending",
			'cellWidth' => null,
			'hideColumnOnSmallDevices' => false
		));
	}
}
class FilterComponentProperties extends ComponentProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'filter' => new FilterProperties()
		));
	}
}
class FilterProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'items' => new PropertyList('FilterItemProperties')
		));
	}
}
class FilterItemProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'type' => "",
			'label' => "",
			'list' => "string",
			'options' => "",
			'range' => "",
			'value' => ""
		));
	}
}
class KPITableComponentProperties extends ComponentProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'kpitable' => new KPITableProperties()
		));
	}
}
class KPITableProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'items' => new PropertyList('KPIDisplayProperties')
		));
	}
}
class KPITableItem extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'caption' => "",
			'value' => ""
		));
	}
}
class TabbedComponentProperties extends ComponentProperties {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'children' => new PropertyList('TabItemProperties'),
			'tabbed' => new TabbedCoreProperties()
		));
	}
}
class TabbedCoreProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'activeIndex' => 0
		));
	}
}
class TabItemProperties extends PropertyBase {
	public function init () {
		parent::init ();
		
		$this->register (array(
			'name' => "",
			'componentId' => ""
		));
	}
}
