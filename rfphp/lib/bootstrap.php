<?php

if(file_exists(RF_FOLDER_ROOT."/config/config.php")) {
	require RF_FOLDER_ROOT."/config/config.php";
}
require "core/Dashboard.php";
require "core/StandaloneDashboard.php";
require "components/Component.php";
require "components/KPIComponent.php";
require "components/TableComponent.php";
require "components/ChartComponent.php";
require "components/FilterComponent.php";
require "core/PropertyBase.php";
require "core/DataSource.php";
require "core/Properties.php";
require "core/RFAssert.php";
require "util/RFUtil.php";
require "util/ArrayUtils.php";


// Register the autoloader
function _fr_autoload ($className)
{
    // We can't autoload right now
}
spl_autoload_register('_fr_autoload');


