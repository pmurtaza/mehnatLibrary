var xar= new Array();
var xct= -1;
function getxmlhttp()
    {
    xct++;
    try
	{
	xar[xct]= new ActiveXObject("Msxml2.XMLHTTP");
	}
    catch(e)
	{
	try
	    {
	    xar[xct]= new ActiveXObject("Microsoft.XMLHTTP");
	    }
	catch(E)
	    {
	    }
	}
    if(!xar[xct] && typeof XMLHttpRequest != 'undefined') 
	{
	xar[xct]= new XMLHttpRequest();
	};
    return xar[xct];
    };
function post_sel_ind(url, str)
    {
    aj= getajaxobj();
    aj.open("POST", url);
    aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    aj.setRequestHeader("Content-length", url.length);
    aj.setRequestHeader("Connection", "close");
    aj.onreadystatechange= function()
	{
	if(aj.readyState == 4 && aj.status == 200)
	    {
	    if("logoff" == aj.responseText)
		window.location.href= "/index.php";
	    else
		{
		// alert(aj.responseText);
		var si= window.document.getElementById("sel_ind");
		si.innerHTML= aj.responseText;
		get_reg_n_indic_tot();
		};
	    };
	}
    aj.send(str);
    };
function ins_sel_ind(url, tab_code)
    {
    url= "/kommon/bin/sr.php?kall=wjskall&tab_code=" + tab_code + "&dkall=setunset" + "&setft=1";
    var icode_arr= window.document.getElementsByName("indlist[]");
    var len= icode_arr.length;
    var indic= window.document.getElementById("sel_ind");
    indic.innerHTML=  "loading...";
    var str= "";
    var counter= 1;
    for(var i= 0; i < len; i++)
	{
	if(icode_arr[i].checked && icode_arr[i].value != "on")
	    {
	    str= str + "&ind[]=" + icode_arr[i].value;
	    counter++;
	    };
	if(counter % 990 == 0)
	    {
	    post_sel_ind(url, str);
	    counter= 0;
	    str= "";
	    };
	};
    if(counter != 0 && str != "")
	post_sel_ind(url, str);
    };
