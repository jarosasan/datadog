<?php
	$start = microtime(true);
	require_once "config.php";

	include "view/index.php";
//	 autoloading classes




	

	echo "<div style='position: absolute; right: 0; top: 0; padding: 6px; background-color: rgba(252,57,0,0.8); z-index: 100; color: white'>";
	echo round((microtime(true) - $start), 2) . " ms.";
	echo "<br>" . round(memory_get_peak_usage()/(1024*1024), 2) . " MB.";
	echo "</div>";
	
	