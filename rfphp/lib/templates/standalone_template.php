<?php
global $rfTemplateData;
$staticRoot = $rfTemplateData['staticRoot'];
$dashboardData = $rfTemplateData['dbAsJson'];

?>
<!doctype html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <script type="text/javascript">
    var renderDashboard = function () {
        var builder = new rf.StandaloneBuilder();
        var dbAsJson = <?php echo $dashboardData; ?>;
        builder.buildDashboardFromObject (dbAsJson);
    };
    </script>


    <?php if (function_exists('_rf_alternate_head')) { ?>
    <?php _rf_alternate_head (); ?>
    <?php } else { ?>

    <link rel="stylesheet" href="<?php echo $staticRoot; ?>/css/razorflow.min.css"/>
    <script type="text/javascript" src="<?php echo $staticRoot; ?>/js/razorflow.wrapper.min.js"></script>
    <?php } ?>
</head>
<body>
<div id="dbTarget">
</div>
</body>
<?php if(function_exists('_rf_alternate_body')) { _rf_alternate_body(); } else { ?>
  <script type="text/javascript">
    renderDashboard();
  </script>
<?php } ?>
</html>
