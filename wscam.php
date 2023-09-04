<?php
    include_once("page.php");
    include_once("test.php");
    class cwscam extends cpage
        {
        function content()
            {
	          $p= new cini();
	          $p->draw();
            return 0;
            }
        function cwscam()
            {
            // cpage::cpage();
            parent::__construct();
            }
        };
    $o= new cwscam();
    $o->page();
    ?>
