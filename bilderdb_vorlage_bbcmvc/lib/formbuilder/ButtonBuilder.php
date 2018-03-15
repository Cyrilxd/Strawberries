<?php
  /**
   * Erstellt einen Button für ein Formular.
   * Da mehrere Buttons auf einer Zeile möglich sind, werden die <div>- und <label>-
   * Start- und End-Tags separat erstellt.
   * Es sind sowohl Buttons möglich als auch Links, die wie Buttons aussehen.
   */
  class ButtonBuilder extends Builder
  {
    public function __construct()
    {
      $this->addProperty('label');
      $this->addProperty('name');
      $this->addProperty('type');
      $this->addProperty('class');
      $this->addProperty('link');
    }
    public function start($lblClass, $eltClass) {
      $result  = "<div class='form-group'>\n";
      $result .= "<label class='$lblClass' control-label' for='textinput'>&nbsp;</label>\n";
      $result .= "<div class='$eltClass'>\n";
	  return $result;
	}
    public function build()
    {
	  if ($this->type == "link") {
        $result = "<a name='{$this->name}' href='".$GLOBALS['appurl']."{$this->link}' class='btn {$this->class}'>{$this->label}</a>";
	  } else {
        $result = "<input name='{$this->name}' type='{$this->type}' class='btn {$this->class}' value='{$this->label}' />\n";
	  }
	  return $result;
    }
    public function end() {
	  $result  = "</div>\n";
	  $result .= "</div>\n";
	  return $result;
	}
  }
?>