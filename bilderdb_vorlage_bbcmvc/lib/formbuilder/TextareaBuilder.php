<?php
  /**
   * Erstellt ein Textarea-Feld für ein Formular.
   */
  class TextareaBuilder extends Builder
  {
    public function __construct()
    {
      $this->addProperty('label');
      $this->addProperty('name');
      $this->addProperty('rows');
      $this->addProperty('value', null);
      $this->addProperty('lblClass');
      $this->addProperty('eltClass');
    }
    public function build()
    {
      $result  = "<div class='form-group'>";
      $result .= "<label class='{$this->lblClass} control-label' for='textinput'>{$this->label}</label>";
      $result .= "<div class='{$this->eltClass}'>";
      $result .= "<textarea style='overflow:hidden' name='{$this->name}' rows='{$this->rows}' class='form-control'>{$this->value}</textarea>";
      $result .= "</div>";
      $result .= "</div>";
      return $result;
    }
  }
?>