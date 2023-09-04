<?php
  include_once("mylib.php");
  function inclall($file) {
    $path= [
      ".",
      "../skeleton",
      "../../skeleton",
    ];
    for($i= 0, $flag= TRUE; $flag && $i < count($path); $i++)
      if(file_exists($fpath= sprintf("%s/$file", $path[$i])))
        {
        // debug($fpath, "if");
        include_once($fpath);
        $flag= FALSE;
        }
        else
        {
        // debug($fpath, "else");
        }
    return 0;
  };
  ?>