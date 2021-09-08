<?php
require_once("json_encode.php");

function validateX($xVal)
{
  return isset($xVal);
}

function validateY($yVal)
{
  $Y_MIN = -5;
  $Y_MAX = 3;

  if (!isset($yVal))
    return false;

  $numY = str_replace(',', '.', $yVal);
  return is_numeric($numY) && $numY >= $Y_MIN && $numY <= $Y_MAX;
}

function validateR($rVal)
{
  return isset($rVal);
}

function validateForm($xVal, $yVal, $rVal)
{
  return validateX($xVal) && validateY($yVal) && validateR($rVal);
}

// Hit check functions
function checkTriangle($xVal, $yVal, $rVal)
{
  return $xVal >= 0 && $yVal <= 0 &&
    $xVal <= $yVal/2 + $rVal/2;
}

function checkRectangle($xVal, $yVal, $rVal)
{
  return $xVal <= 0 && $yVal >= 0 &&
    abs($xVal) <= $rVal && $yVal <= $rVal / 2;
}

function checkCircle($xVal, $yVal, $rVal)
{
  return $xVal <= 0 && $yVal <= 0 &&
    sqrt($xVal * $xVal + $yVal * $yVal) <= $rVal;
}

function checkHit($xVal, $yVal, $rVal)
{
  return checkTriangle($xVal, $yVal, $rVal) || checkRectangle($xVal, $yVal, $rVal) ||
    checkCircle($xVal, $yVal, $rVal);
}

// Main logic
$xArray = [];
$xArray = $_POST['xval'];
$result = array();
$rArray = [];
$rArray = $_POST['rval'];
$yVal = $_POST['yval'];
$timezoneOffset = $_POST['timezone'];
$currentTime = date('H:i:s', time() - $timezoneOffset * 60);
foreach ($xArray as $i => $xVal) {  	 
     foreach ($rArray as $j => $rVal) { 
$isValid = validateForm($xVal, $yVal, $rVal);
  $converted_isValid = $isValid ? true : false;
  $isHit = $isValid ? checkHit($xVal, $yVal, $rVal) : 'Easter egg!';
  $converted_isHit = $isHit ? true : false;

  $executionTime = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 7);

  array_push($result, array(
    "validate" => $converted_isValid,
    "xval" => $xVal,
    "yval" => $yVal,
    "rval" => $rVal,
    "hitres" => $converted_isHit,
    "curtime" => $currentTime,
    "exectime" => $executionTime
  ));
}
}
echo toJSON($result);