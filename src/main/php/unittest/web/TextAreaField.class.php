<?php namespace unittest\web;

/**
 * Represents a HTML textarea field
 *
 * @see   http://www.w3schools.com/TAGS/tag_textarea.asp
 * @see   xp://unittest.web.Field
 */
class TextAreaField extends Field {

  /**
   * Get this field's value
   *
   * @return  string
   */
  public function getValue() {
    return $this->node->textContent;
  }

  /**
   * Set this field's value
   *
   * @param   string value
   */
  public function setValue($value) {
    $this->node->textContent= $value;
  }
}
