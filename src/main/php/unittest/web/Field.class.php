<?php namespace unittest\web;

/**
 * Represents a HTML field
 *
 * @see   xp://unittest.web.Form#getFields
 */
abstract class Field extends \lang\Object {
  protected
    $form   = null,
    $node   = null;
  
  /**
   * Constructor
   *
   * @param   unittest.web.Form form owner form
   * @param   php.DOMNode node
   */
  public function __construct(Form $form, \DOMNode $node) {
    $this->form= $form;
    $this->node= $node;
  }
  
  /**
   * Get this field's name
   *
   * @return  string
   */
  public function getName() {
    return $this->node->getAttribute('name');
  }

  /**
   * Get this field's value
   *
   * @return  string
   */
  public abstract function getValue();

  /**
   * Set this field's value
   *
   * @param   string value
   */
  public abstract function setValue($value);
  
  /**
   * Creates a string representation
   *
   * @return  string
   */
  public function toString() {
    return nameof($this).'{'.$this->form->getTest()->getDom()->saveXML($this->node).'}';
  }
}
