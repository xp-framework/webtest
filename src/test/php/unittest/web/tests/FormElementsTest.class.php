<?php namespace unittest\web\tests;

use peer\http\HttpConstants;

class FormElementsTest extends WebTestCaseTest {

  /**
   * Returns the form used for testing below
   *
   * @return  string
   */
  protected function formFixture() {
    return trim('
      <html>
        <head>
          <title>Enter your name</title>
        </head>
        <body>
          <form>
            <input type="text" name="first"/>
            <input type="text" name="initial" value=""/>
            <input type="text" name="last" value="Tester"/>
            <input type="text" name="uber" value="Ubercoder"/>

            <hr/>
            <select name="gender">
              <option value="-">(select one)</option>
              <option value="M">male</option>
              <option value="F">female</option>
              <option value="U">Uberwoman</option>
            </select>

            <hr/>
            <select name="payment">
              <option value="V">Visa-Card</option>
              <option value="M">Master-Card</option>
              <option value="C" selected>Cheque</option>
            </select>

            <hr/>
            <textarea name="comments">(Comments)</textarea>
          </form>
        </body>
      </html>
    ');
  }

  #[@test, @expect('lang.IllegalArgumentException')]
  public function nonExistantField() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    $this->fixture->getForm()->getField('does-not-exist');
  }

  #[@test]
  public function textFieldWithoutValue() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    with ($f= $this->fixture->getForm()->getField('first')); {
      $this->assertInstanceOf('unittest.web.InputField', $f);
      $this->assertEquals('first', $f->getName());
      $this->assertEquals(null, $f->getValue());
    }
  }

  #[@test]
  public function textFieldWithEmptyValue() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    with ($f= $this->fixture->getForm()->getField('initial')); {
      $this->assertInstanceOf('unittest.web.InputField', $f);
      $this->assertEquals('initial', $f->getName());
      $this->assertEquals('', $f->getValue());
    }
  }

  #[@test]
  public function textFieldWithValue() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    with ($f= $this->fixture->getForm()->getField('last')); {
      $this->assertInstanceOf('unittest.web.InputField', $f);
      $this->assertEquals('last', $f->getName());
      $this->assertEquals('Tester', $f->getValue());
    }
  }

  #[@test]
  public function textFieldWithUmlautInValue() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    with ($f= $this->fixture->getForm()->getField('uber')); {
      $this->assertInstanceOf('unittest.web.InputField', $f);
      $this->assertEquals('uber', $f->getName());
      $this->assertEquals('Ubercoder', $f->getValue());
    }
  }

  #[@test]
  public function selectFieldWithoutSelected() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    with ($f= $this->fixture->getForm()->getField('gender')); {
      $this->assertInstanceOf('unittest.web.SelectField', $f);
      $this->assertEquals('gender', $f->getName());
      $this->assertEquals('-', $f->getValue());
    }
  }

  #[@test]
  public function selectFieldWithSelected() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    with ($f= $this->fixture->getForm()->getField('payment')); {
      $this->assertInstanceOf('unittest.web.SelectField', $f);
      $this->assertEquals('payment', $f->getName());
      $this->assertEquals('C', $f->getValue());
    }
  }

  #[@test]
  public function selectFieldOptions() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    with ($options= $this->fixture->getForm()->getField('gender')->getOptions()); {
      $this->assertEquals(4, sizeof($options));

      $this->assertEquals('-', $options[0]->getValue());
      $this->assertEquals('(select one)', $options[0]->getText());
      $this->assertFalse($options[0]->isSelected());

      $this->assertEquals('M', $options[1]->getValue());
      $this->assertEquals('male', $options[1]->getText());
      $this->assertFalse($options[1]->isSelected());

      $this->assertEquals('F', $options[2]->getValue());
      $this->assertEquals('female', $options[2]->getText());
      $this->assertFalse($options[2]->isSelected());

      $this->assertEquals('U', $options[3]->getValue());
      $this->assertEquals('Uberwoman', $options[3]->getText());
      $this->assertFalse($options[3]->isSelected());
    }
  }

  #[@test]
  public function selectFieldNoSelectedOptions() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    $this->assertEquals([], $this->fixture->getForm()->getField('gender')->getSelectedOptions());
  }
  
  #[@test]
  public function selectFieldSelectedOptions() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    with ($options= $this->fixture->getForm()->getField('payment')->getSelectedOptions()); {
      $this->assertEquals(1, sizeof($options));

      $this->assertEquals('C', $options[0]->getValue());
      $this->assertEquals('Cheque', $options[0]->getText());
      $this->assertTrue($options[0]->isSelected());
    }
  }

  #[@test]
  public function textArea() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $this->formFixture());
    $this->fixture->beginAt('/');

    with ($f= $this->fixture->getForm()->getField('comments')); {
      $this->assertInstanceOf('unittest.web.TextAreaField', $f);
      $this->assertEquals('comments', $f->getName());
      $this->assertEquals('(Comments)', $f->getValue());
    }

  }
}