<?php
  class Form
  {
    public function __construct($action = '#', $method = 'POST', $enctype = "")
    {
      echo "<form class='form-horizontal' action='".$action."' method='".$method."' enctype='".$enctype."'>\n";
      echo "<div class='component' data-html='true'>\n";
    }

    public function end()
    {
      $result  = "</div>\n";
      $result .= "</form>\n";
	  return $result;
    }

    public function __call($name, $args)
    {
      $builderName = ucfirst($name).'Builder';
      return new $builderName();
    }
  }
?>