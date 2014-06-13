<?php

global $_rfConfig;

/**
 * Defaukt configuration settings.
 * staticRoot => Provide the url for serving the static assets.
 * rfDev => Enable development mode. Useful for debugging rfjs bugs/errors.
 */

$_rfConfig = array(
  "staticRoot" => "/src/static/rf",
  "rfDev" => false,
  "rfDebug" => true
);

