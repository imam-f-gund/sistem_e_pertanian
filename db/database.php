<?php
$mysqli = new mysqli("localhost","root","","rosw8953_si_kwt");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
