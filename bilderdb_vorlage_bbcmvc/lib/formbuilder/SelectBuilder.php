<?php
  /**
   * Erstellt eine Dropdown-Liste für ein Formular.
   * Da die Werte für die Liste im allgemeinen dynamisch sind (z.B. aus einer Tabelle stammen),
   * wird das select-Tag nicht abgeschlossen. D.h. die <option>-Werte werden in der View generiert,
   * darauf wird das select-Tag mit end() abgeschlossen.
   */
  class SelectBuilder extends Builder
  {
    public function __construct()
    {
      $this->addProperty('label');
      $this->addProperty('name');
      $this->addProperty('lblClass');
      $this->addProperty('eltClass');
    }
    public function build()
    {
      $result  = "<div class='form-group'>\n";
      $result .= "<label class='{$this->lblClass} control-label' for='textinput'>{$this->label}</label>\n";
      $result .= "<div class='{$this->eltClass}'>\n";
	  $result .= "<select name='{$this->name}' class='form-control'>\n";
	  $result .= "<option value='NULL'></option>\n";
      return $result;
    }
    public function end() {
	  $result  = "</select>\n";
	  $result .= "</div>\n";
	  $result .= "</div>\n";
	  return $result;
	}
  }
?>