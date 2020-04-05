<?php namespace unittest\web;

/**
 * Represents a HTML Select field
 *
 * @see   http://www.w3schools.com/TAGS/tag_Select.asp
 * @see   xp://unittest.web.Field
 */
class SelectField extends Field {

  /**
   * Get this field's value
   *
   * @return  string
   */
  public function getValue() {
    if (!$this->node->hasChildNodes()) return null;

    // Find selected
    foreach ($this->node->childNodes as $child) {
      if (!($child instanceof \DOMElement) || 'option' !== $child->tagName || !$child->hasAttribute('selected')) continue;
      return $child->getAttribute('value');
    }
    
    // Use first child's value
    return $this->node->childNodes->item(0)->getAttribute('value');
  }
  
  /**
   * Returns options
   *
   * @return  unittest.web.SelectOption[]
   */
  public function getOptions() {
    $r= [];
    foreach ($this->node->childNodes as $child) {
      if (!($child instanceof \DOMElement) || 'option' !== $child->tagName) continue;
      $r[]= new SelectOption($this->form, $child);
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
    foreach ($this->node->childNodes as $child) {
      if (!($child instanceof \DOMElement) || 'option' !== $child->tagName || !$child->hasAttribute('selected')) continue;
      $r[]= new SelectOption($this->form, $child);
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
