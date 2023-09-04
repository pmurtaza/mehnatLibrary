<?php
    include_once("mylib.php");
    //
    class cini
        {
	public $x;
	public $nv;
	//
	function lib_definekall(&$args)
	    {
	    return $args[1];
	    }
	function lib_setoperation0(&$args)
	    {
	    $this->x->reprint_sect("setoperation0");
	    return 0;
	    }
	function lib_get_curr_set_det_sess(&$args)
	    {
	    $this->x->reprint_sect_nv("curr_set_det_sess", $this->nv);
	    return 0;
	    }
	function lib_setoperation1(&$args)
	    {
	    $this->x->reprint_sect("setoperation1");
	    return 0;
	    }
	function lib_setoperation2(&$args)
	    {
	    return "strings xxx";
	    }
	function init()
	    {
	    $this->x->register($this);
	    $this->x->parse_ini('page.htm');
		//
	    $this->x->sect("setoperation");
	    //$this->x->resect_nv($txt, "curr_set_det_sess", $this->nv);
	    //$this->x->print_($txt);
	    return 0;
	    }
	function draw()
	    {
	    /*
	    $con = mysqli_connect("beas", "soi", "soi@cmie", "soi");
	    $nv= array();
	    $nv["event_date"]= "2009-01-02 10:10:41"; 
	    $nv["description"]= "t";
	    $nv["de_person"]= "pmurtaza";
	    // debug(qtohs($con, "select * from soical"));
	    update($con, "soical", $nv);
	    */
		// $sql = "SELECT * FROM employee"; // ORDER BY Lastname";
        //     // $sql = "SELECT * FROM Hqhb_department"; // ORDER BY Lastname";
        //     $result = $mysqli -> query($sql);
	    $this->init();
      $host= "143.110.184.83";
		  $username="nqrvykkmma"; 
      $password="x4GrUxnE4B"; 
      $database="nqrvykkmma"; 
      $con= MySqli($host, $username, $password, $database);
      // $con = new mysqli($host, $username, $password, $database);
      // debug($con);
      $res= qtohs($con, "SELECT * FROM HQHB_DEPARTMENT");
      debug($res);
	    return 0;
	    }
	// function cini()
	function __construct()
	    {
	    $this->x= new cmylib();
	    $this->nv= array();
	    $this->nv["SESS_SET"]= "NaWaB"; 
	    $this->nv["AND"]     = sprintf("<img src=\"/image/and.gif\" height=\"17\" width=\"17\">");
	    $this->nv["OR"]      = sprintf("<img src=\"/image/or.gif\" height=\"17\" width=\"17\">");
	    $this->nv["NOT"]     = sprintf("<img src=\"/image/not.gif\" height=\"17\" width=\"17\">");
	    }
	};
    $obj= new cini();
    ?>
