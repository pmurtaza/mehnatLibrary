<?php
  include_once("mylib.php");
  // require_once("mylib.php");
  class cpage
      {
      public $x;
      //
      function esp($sect)  { return $this->x->reprint_sect($sect); }
      function content()   { $this->esp("home_content_dc"); return 0; }
      function page0()     { return 0; }
      function page1()
        {
        $this->esp("HTML0");
          $this->esp("HTML1");
              $this->content();
          $this->esp("HTML2");
        return 0;
        }
      function page2() { return 0; }
      function page()
        {
        $this->page0();
          $this->page1();
        $this->page2();
        return 0;
        }
      // function cpage()  { }
      function __construct()
        {
        $this->x= new cmylib();
        $this->x->register($this);
        $this->x->parse_ini('page.htm');
        }
      };
  ?>
