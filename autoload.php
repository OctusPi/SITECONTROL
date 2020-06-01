<?php
// auto included class requerides

  function ocp_autoload ($pClassName) {
      if(file_exists(__DIR__ . "/class/" . $pClassName . ".php")):
            include_once(__DIR__ . "/class/" . $pClassName . ".php");
      endif;
  }

  spl_autoload_register("ocp_autoload");