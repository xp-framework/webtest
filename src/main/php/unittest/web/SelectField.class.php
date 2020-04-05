<?php namespace unittest\web;

/**
 * Represents a HTML Select field
 *
 * @see   http://www.w3schools.com/TAGS/tag_Select.asp
 * @see   xp://unittest.web.Field
 */
class SelectField extends Field {

  /** @return DOMElement[] */
  private function options() {
    $r= [];
    foreach ($this->node->childNodes as $child) {
      if ($child instanceof \DOMElement && 'option' === $child->tagName) $r[]= $child;
    }
    return $r;
  }

  /**
   * Get this field's value
   *
   * @return  string
   */
  public function getValue() {
    $options= $this->options();
    if (empty($options)) return null;

    // Find selected
    foreach ($options as $option) {
      if ($option->hasAttribute('selected')) return $option->getAttribute('value');
    }

    // Use first child's value
    return $options[0]->getAttribute('value');
  }
  
  /**
   * Returns options
   *
   * @return  unittest.web.SelectOption[]
   */
  public function getOptions() {
    $r= [];
    foreach ($this->options() as $option) {
      $r[]= new SelectOption($this->form, $option);
    }
    return $r;
  }

  /**
   * Returns selected option (or NULL if no option is selected)
   *
   * @return  unittest.web.SelectOption[]
   */
  public function getSelectedOptions() {
    $r= [];
    foreach ($this->options() as $option) {
      $option->hasAttribute('selected') && $r[]= new SelectOption($this->form, $option);
    }
    return $r;
  }

  /**
   * Set this field's value
   *
   * @param   string value
   */
  public function setValue($value) {
    $found= false;
    foreach ($this->node->childNodes as $child) {
      if ($value !== $child->getAttribute('value')) {
        $update[]= $child;
        continue;
      }
      $child->setAttribute('selected', 'selected');
      $found= true;
    }
    
    if (!$found) throw new \lang\IllegalArgumentException('Cannot set value');
    
    foreach ($update as $child) {
      $child->removeAttribute('selected');
    }
  }
}
