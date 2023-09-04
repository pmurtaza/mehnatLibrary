<?php
    session_start();
    //
    class cmylib
        {
	public $tpl;
	public $klass;
	public $classname;
	//
  function callproc(&$rs, &$that, $proc, $args)
    {
    if(!is_null($that) && method_exists($that, $proc))
        {
        $rs= $that->$proc($args);
        $rc= 0;
        }
    else
        $rc= -2;
    return $rc;
    }
  function register($callclass, $class= "default")
      {
      $this->classname= $class;
      $this->klass["class"][$class]= array();
      $this->klass["class"][$this->classname]= $callclass;
      return 0;
      }
	function preggie($str= NULL, $obra= "[", $cbra= "]", $cnt= 1) 
	    {
	    preg_match("/\[([^\]]*)\]/", $str, $matches);
	    return $matches[1];
	    }
	function parse_ini($filename) 
	    {
	    if(file_exists($filename) && filesize($filename) > 0)
			{
			$section= "start_tpl";
			$fp= fopen($filename, "r") or die("Couldn't open $filename");
			while(!feof($fp)) 
				{
				$line= fgets($fp, 1024);
				$line= rtrim($line);
				if(!empty($line) && strcmp($line, "") != 0 && !is_null($line))
					{
					if($line[0] == '[' && $line[1] != '[')
						{
						$section= $this->preggie($line); 
						if(!array_key_exists($section, $this->tpl))
							$this->tpl[$section]= array();
						continue;
						}; 
					array_push($this->tpl[$section], $line);
					}; 
				}; 
			}
			else
				printf("Error: File not Found or Found to be Empty!!");
	    return 0;
	    }
	function print_sect($sect, $args= array())
	    {
	    foreach($this->tpl[$sect] as $key => $val)
		printf("%s\n", $val);
	    return 0;
	    }
	function preggie_wit_style($str, $ob, $cb, $cnt= 1)
	    {
	    $mu= sprintf("@%s(.*?)%s@", str_repeat(sprintf("\\%s", $ob), $cnt), str_repeat(sprintf("\\%s", $cb), $cnt));
	    preg_match_all($mu, $str, $m);
	    return $m[1];
	    }
	function executeline($line, $bool= 0)
	    {
	    $matches= array();
	    if(FALSE) { }
	    else if(preg_match("/\{\{(.*?)\}\}/", $line))
		{
		$matches= $this->preggie_wit_style($line, $this->klass["ocb"], $this->klass["ccb"], 2);
		$flag= 1;
		}
	    else if(preg_match("/\[\[(.*?)\]\]/", $line))
		{
		$matches= $this->preggie_wit_style($line, $this->klass["osb"], $this->klass["csb"], 2);
		$flag= 2;
		}
	    else 
		{ 
		$flag= 0; 
		};
	    $rc= 0;
	    if(count($matches) > 0)
		{
		for($i= 0, $rc= 0; $i < count($matches); $i++)
		    {
		    if(!empty($matches[$i]))
			{
			$args= explode("|", $matches[$i]);
			if(strcmp($args[0], "print_sect") == 0)
			    $this->reprint_sect($args[1], $args);
			else
			    {
			    if(FALSE) { }
			    else if($bool == 1010)
				{
				if(FALSE) { }
				else if($flag == 1)
				    {
				    $rc= $this->callproc($rs, $this->klass["class"][$this->classname], sprintf("%s%s", $this->klass["kall"], $args[0]), $args);
				    return $rs;
				    }
				else if($flag == 2)
				    {
				    $rc= $this->callproc($rs, $this->klass["class"][$this->classname], sprintf("%s%s", $this->klass["kall"], $args[0]), $args);
				    return $rs;
				    }
				else { };
				}
			    else if($bool == 2020)
				{
				if(FALSE) { }
				else if($flag == 1)
				    {
				    $rc= $this->callproc($rs, $this->klass["class"][$this->classname], sprintf("%s%s", $this->klass["kall"], $args[0]), $args);
				    $line= str_replace($this->klass["ocb"] , "", $line);
				    $line= str_replace($this->klass["ccb"] , "", $line);
				    printf("%s\n", str_replace($matches[$i] , $rs, $line));
				    }
				else if($flag == 2)
				    {
				    $rc= $this->callproc($rs, $this->klass["class"][$this->classname], sprintf("%s%s", $this->klass["kall"], $args[0]), $args);
				    // $line= str_replace($this->klass["osb"] , "", $line);
				    // $line= str_replace($this->klass["csb"] , "", $line);
				    // printf("%s\n", str_replace($matches[$i] , $rs, $line));
				    }
				else { };
				}
			    else if($flag == 1)
				{
				$rc= $this->callproc($rs, $this->klass["class"][$this->classname], sprintf("%s%s", $this->klass["kall"], $args[0]), $args);
				printf("%s\n", $rs);
				}
			    else if($flag == 2)
				{
				$rc= $this->callproc($rs, $this->klass["class"][$this->classname], sprintf("%s%s", $this->klass["kall"], $args[0]), $args);
				};
			    };
			};
		    };
		}
	    else
		{
		if($bool == 1010)
		    return $line; 
		else
		    print("$line \n");
		}
	    return $rc;
	    }
	function print_($str)
	    {
	    if(is_array($str))
		{
		for($i=0; $i < count($str); $i++)
		    $this->executeline($str[$i]);
		}
	    else
		printf("%s\n", $str);
	    }
	function sect($sect, $args= array())
	    {
	    $cnt= count($this->tpl[$sect]);
	    for($i=0, $rc= 0; $i < $cnt; $i++)
		{
		$rc= $this->executeline($this->tpl[$sect][$i], 2020);
		};
	    return 0;
	    }
	function reprint_sect($sect, $args= array())
	    {
	    $cnt= count($this->tpl[$sect]);
	    for($i=0, $rc= 0; $i < $cnt; $i++)
		{
		$rc= $this->executeline($this->tpl[$sect][$i]);
		};
	    return 0;
	    }
	function resect_nv(&$str, $sect, $nv)
	    {
	    $str= "";
	    $txt= implode("@@", $this->tpl[$sect]);
	    $txt= preg_replace("/##/", "", $txt);
	    $txt= str_replace(array_keys($nv), array_values($nv), $txt);
	    $txt= explode("@@", $txt);
	    $cnt= count($txt);
	    for($i= 0; $i < $cnt; $i++)
		$str.= $this->executeline(trim($txt[$i]), 1010); 
	    return 0;
	    }
	function reprint_sect_nv($sect, $nv)
	    {
	    $str= implode("@@", $this->tpl[$sect]);
	    $str= preg_replace("/##/", "", $str);
	    $str= str_replace(array_keys($nv), array_values($nv), $str);
	    $str= explode("@@", $str);
	    $this->print_($str);
	    return 0;
	    }
	// function cmylib()
  function __construct()
	    {
	    $this->tpl= array();
	    $this->klass= array();
	    $this->klass["osb"]= "[";
	    $this->klass["csb"]= "]";
	    $this->klass["ocb"]= "{";
	    $this->klass["ccb"]= "}";
	    $this->klass["kall"]= "lib_";
	    }
	};
    function vars()            { return array_merge($_GET, $_POST);                                                                 };
    function gvars($k)         { $vars= vars(); return isset($vars[$k]) ? $vars[$k]                                        : "";    };
    function isvars($k)        { $vars= vars(); return isset($vars[$k]) ? TRUE                                             : FALSE; };
    function sessvars()        { $vars= $_SESSION; return $vars;                                                                    };
    function dgvars($k, $defa) { $vars= vars(); return isset($vars[$k]) ? (strcmp($vars[$k], "") != 0 ? $vars[$k] : $defa) : $defa; };
    function MySqli($host, $username, $password, $database) {
      $mysqli = new mysqli($host, $username, $password, $database);
      $mysqli->select_db($database) or die("Unable to select database");
      if ($mysqli -> connect_errno) {
          echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
          exit();
      } else {
        //
      };
      return $mysqli;
  };
    function query($con, $qry)
	{
	if($con->connect_error) 
	    {
	    die("Connection failed: " . $con->connect_error);
	    }
	else
	    {
	    $res= $con->query($qry);
	    if(isvars("er"))
		{
		printf("+%s+\n", str_repeat("-", strlen($qry) + 2));
		print "| $qry |";
		print "\n";
		printf("+%s+\n", str_repeat("-", strlen($qry) + 2));
		};
	    };
	// $con->close();
	return $res;
	};
    function qtov($con, $qry)
	{
	$data= array();
	$res= query($con, $qry);
	if($res->num_rows > 0)
	    {
	    $field = mysqli_fetch_field($res);
	    $row= $res->fetch_assoc();
	    $v= $row[$field->name];
	    };
	return $v;
	};
    function qtoh($con, $qry)
	{
	$data= array();
	$res= query($con, $qry);
	return $res->fetch_assoc();
	};
    function qtohs($con, $qry)
	{
	$data= array();
	$res= query($con, $qry);
	if(isset($res->num_rows) && $res->num_rows > 0)
	    {
	    while($row= $res->fetch_assoc()) 
		  array_push($data, $row);
	    };
	return $data;
	};
    function mkline($row, $sp)
	{
	return sprintf("%s%s", $sp, implode($sp, $row));
	};
    function qtol($con, $qry, $sp= "~")
	{
	$data= array();
	$res= query($con, $qry);
	return  mkline($res->fetch_assoc(), $sp);
	};
    function qtols($con, $qry, $sp= "~")
	{
	$data= array();
	$res= query($con, $qry);
	if($res->num_rows > 0)
	    {
	    while($row= $res->fetch_assoc()) 
		array_push($data, mkline($row, $sp));
	    };
	return $data;
	};
    function qtor($con, $qry, $sp= "~")
	{
	$data   = array();
	$res    = query($con, $qry);
	$field  = mysqli_fetch_field($res);
	$row    = $res->fetch_assoc();
	$data[0]= $row[$field->name];
	return $data;
	};
    function qtors($con, $qry)
	{
	$data   = array();
	$res    = query($con, $qry);
	$field  = mysqli_fetch_field($res);
	$counter= 0;
	if($res->num_rows > 0)
	    {
	    while($row= $res->fetch_assoc())
		{
		$data[$counter]= $row[$field->name];
		$counter++;
		};
	    };
	return $data;
	};
    function datatype() { return array("date", "datetime", "timestamp", "time", "year", "char", "varchar", "blob", "text", "tinyblob", "tinytext", "mediumblob", "mediumtext", "longblob", "longtext", "enum"); };
    function twp($str, &$t, &$w, &$p)
	{
	$str= preg_replace("/\s*/", "", $str);
	if(FALSE){}
	elseif(preg_match("/(.*)\((\d+),(\d+)\)/", $str, $twp)) { $t= $twp[1]; $w= $twp[2]; $p= $twp[3]; }
	elseif(preg_match("/(.*)\((\d+)\)/", $str, $twp))       { $t= $twp[1]; $w= $twp[2]; $p= 0; }
	else                                                    { $t= $str;    $w= 0;       $p= 0;};
	return 0;
	};
    function tbl_desc($con= NULL, $tblnm= NULL)
	{
	$tbl= array();
	$tbl["datatype"]= array();
	$tbl["field"]= array();
	$tbl["primary"]= array();
	$tbl["notnull"]= array();
	$tbl["schema"]= array();
	//
	$tbl["schema"]= qtohs($con, sprintf("%s %s", "desc", $tblnm));
	$cnt= count($tbl["schema"]);
	for($i= 0; $i < $cnt; $i++)
	    {
	    array_push($tbl["field"], $tbl["schema"][$i]["Field"]);
	    $tbl["datatype"][$tbl["schema"][$i]["Field"]]= $tbl["schema"][$i]["Type"];
	    //
	    if(strcmp($tbl["schema"][$i]["Key"], "PRI") == 0)
		array_push($tbl["primary"], $tbl["schema"][$i]["Field"]);
	    if(strcmp($tbl["schema"][$i]["Null"], "NO") == 0)
		array_push($tbl["notnull"], $tbl["schema"][$i]["Field"]);
	    };
	return $tbl;
	};
    function update($con= NULL, $tblnm= NULL, $nv= array())
	{
	$datatype= datatype();
	$tbl= tbl_desc($con, $tblnm);
	$setters= "";
	$wherres= "";
	foreach($nv as $key => $value)
	    {
	    if(in_array($key, $tbl["primary"]))
		{
		twp($tbl["datatype"][$key], $t, $w, $p);
		if(in_array(strtolower($t), $datatype))
		    $wherres.= sprintf("%s= \"%s\" and ", $key, $value);
		else
		    $wherres.= sprintf("%s= %s and ", $key, $value);
		}
	    else
		{
		twp($tbl["datatype"][$key], $t, $w, $p);
		if(in_array(strtolower($t), $datatype))
		    $wherres.= sprintf("%s= \"%s\" and ", $key, $value);
		else
		    $wherres.= sprintf("%s= %s and ", $key, $value);
		};
	    };
	$setters= preg_replace("/, $/", "", $setters);
	$wherres= preg_replace("/and $/", "", $wherres);
	$qry= sprintf("UPDATE %s SET %s WHERE %s", $tblnm, $setters, $wherres);
	$res= query($con, $qry);
	return 0;
	};
    function delete($con= NULL, $tblnm= NULL, $nv= array())
	{
	$datatype= datatype();
	$tbl= tbl_desc($con, $tblnm);
	$vals= "";
	foreach($nv as $key => $value)
	    {
	    if(array_key_exists($key, $tbl["datatype"]))
        {
        twp($tbl["datatype"][$key], $t, $w, $p);
        if(in_array(strtolower($t), $datatype))
            $vals.= sprintf("\"%s\", ", $value);
        else
            $vals.= sprintf("%s, ", $value);
        };
	    };
	$vals= preg_replace("/and $/", "", $vals);
	$qry= sprintf("DELETE FROM %s WHERE %s", $tblnm, $vals);
	$res= query($con, $qry);
	return 0;
	};
    function insert($con= NULL, $tblnm= NULL, $nv= array())
	{
	$datatype= datatype();
	$tbl= tbl_desc($con, $tblnm);
	$cols= "(";
	$vals= "(";
	foreach($nv as $key => $value)
	    {
	    if(array_key_exists($key, $tbl["datatype"]))
		{
		twp($tbl["datatype"][$key], $t, $w, $p);
		$cols.= sprintf("%s, ", $key);
		if(in_array(strtolower($t), $datatype))
		    $vals.= sprintf("\"%s\", ", $value);
		else
		    $vals.= sprintf("%s, ", $value);
		};
	    };
	$cols= preg_replace("/, $/", "", $cols);
	$vals= preg_replace("/, $/", "", $vals);
	$cols.= ")";
	$vals.= ")";
	$qry= sprintf("INSERT INTO %s %s VALUES %s", $tblnm, $cols, $vals);
	$res= query($con, $qry);
	return 0;
	};
    function debug($arr, $header= "DEBUG")
	{
	printf("<h5>%s</h5>\n", $header);
	printf("<pre>\n");
	print_r($arr);
	print "\n";
	printf("</pre>\n");
	return 0;
	};
    function getsessval(&$v, $sess, $key, $k)
	{
	if(array_key_exists($key[$k], $sess))
	    {
	    if(array_key_exists($key[count($key) - 1], $sess))
		$v= $sess[$key[$k]];
	    else
		{
		$sess= $sess[$key[$k]];
		getsessval($v, $sess, $key, $k + 1);
		};
	    };
	return 0;
	};
    function getvsess()        
	{
	$sess= sessvars();
	$args= func_get_args();
	getsessval($v, $sess, $args, 0);
	return $v;
	};
    function dgetvsess()        
	{
	$sess= sessvars();
	$args= func_get_args();
	$defa= $args[count($args) - 1];
	unset($args[count($args) - 1]);
	getsessval($v, $sess, $args, 0);
	$v= is_array($v) ? $v : (strcmp($v, "") == 0 ? $defa : $v); 
	return $v;
	};
    function setvsess()
	{ 
	$ss= sessvars();
	$args= func_get_args();
	$sess= array();
	$cnt= count($args) - 2;
	for($i= $cnt; $i >= 0; $i--)
	    {
	    $key= $sess;
	    $sess= array();
	    if($i == $cnt)
		$key= $args[$i + 1];
	    $sess[$args[$i]]= $key;  
	    };
	$_SESSION= array_replace_recursive($ss, $sess);
	return 0;
	};
    function logit($path, $v, $p= "VAR", $a= TRUE)
	{
	if($fd= fopen($path, sprintf("%s", $a ? "a" : "w")))
	    {
	    fwrite($fd, "--------------------------\n");
	    fwrite($fd, sprintf("%s\n%s\n", $p, print_r($v, TRUE)));
	    fwrite($fd, "--------------------------\n");
	    fclose($fd);
	    };
	return 0;
	};
    function urlqs()
	{
	return getsvar("QUERY_STRING");
	}
    function build_query($nv, $p= "", $l= 0)
	{
	foreach($nv as $n => $v)
	    {
	    $k= $l > 0 ? sprintf("%s[%s]", $p, $n) : (is_int($n) ? sprintf("%s%s", $p, $n) : $n);
	    $r[]= is_array($v) ? build_query($v, $k, $l + 1) : sprintf("%s=%s", $k, urlencode($v));
	    };
	return implode("&", $r);
	};
    function q2nv(&$nv)
	{
	$nv= array();
	parse_str(urlqs(), $nv);
	return 0;
	};
    function qdeln($n)
	{
	q2nv($nv);
	if(array_key_exists($n, $nv)) unset($nv[$n]);
	return build_query($nv);
	};
    function qreplnv($q, $nv)
	{
	$qc= array();
	parse_str($q, $qc);
	return build_query(array_merge($qc, $nv));
	};
    function qrepl($q, $n, $v) { return qreplnv($q, array($n => $v)); }
    function sqreplnv($nv)     { return qreplnv(urlqs(), $nv); }
    function sqrepl($n, $v)    { return qreplnv(urlqs(), array($n => $v)); }
    function urlqnv($n)
	{
	parse_str(urlqs(), $qc);
	return isset($qc[$n]) ? $qc[$n] : NULL;
	};
    function getkall() { return urlqnv("kall"); };
    function kall($nv= array()) { return !is_null(dgetv_merg("kall", NULL)) || (is_array($nv) && array_key_exists("kall", $nv)) ? "/kommon/bin/sr.php" : "/"; };
    function makeurl($nv= array())
	{
	if(!array_key_exists("effdt", $nv)) $nv["effdt"]= get_effdt();
	if(!array_key_exists("regid", $nv)) $nv["regid"]= get_regid();
	// $path= !is_null(dgetv_merg("kall", NULL)) || array_key_exists("kall", $nv) ? "/kommon/bin/sr.php" : "/";
	return sprintf("%s?%s", kall($nv), sqreplnv($nv));
	};
    ?>