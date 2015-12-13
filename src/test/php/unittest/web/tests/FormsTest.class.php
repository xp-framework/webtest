<?php namespace unittest\web\tests;

use unittest\web\Form;
use peer\http\HttpConstants;

class FormsTest extends WebTestCaseTest {

  /**
   * Assertion helper
   *
   * @param   string $action
   * @param   string $method
   * @param   unittest.web.Form $form
   * @throws  unittest.AssertionFailedError
   */
  private function assertForm($action, $method, $form) {
    $this->assertInstanceOf(Form::class, $form);
    $this->assertEquals($action, $form->getAction());
    $this->assertEquals($method, $form->getMethod());
  }

  #[@test]
  public function unnamedForm() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], trim('
      <html>
        <head>
          <title>Enter your name</title>
        </head>
        <body>
          <form action="http://example.com/"/>
        </body>
      </html>
    '));

    $this->fixture->beginAt('/');
    $this->fixture->assertFormPresent();
  }

  #[@test]
  public function noForm() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], trim('
      <html>
        <head>
          <title>Enter your name</title>
        </head>
        <body>
          <!-- TODO: Add form -->
        </body>
      </html>
    '));

    $this->fixture->beginAt('/');
    $this->fixture->assertFormNotPresent();
  }

  #[@test]
  public function namedForms() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], trim('
      <html>
        <head>
          <title>Blue or red pill?</title>
        </head>
        <body>
          <form name="blue" action="http://example.com/one"/>
          <form name="red" action="http://example.com/two"/>
        </body>
      </html>
    '));

    $this->fixture->beginAt('/');
    $this->fixture->assertFormPresent('red');
    $this->fixture->assertFormPresent('blue');
    $this->fixture->assertFormNotPresent('green');
  }
  
  #[@test]
  public function getForm() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], trim('
      <html>
        <head>
          <title>Form-Mania!</title>
        </head>
        <body>
          <form name="one" action="http://example.com/one"></form>
          <form name="two" method="POST" action="http://example.com/two"></form>
          <form name="three"></form>
        </body>
      </html>
    '));

    $this->fixture->beginAt('/');

    $this->assertForm('http://example.com/one', HttpConstants::GET, $this->fixture->getForm('one'));
    $this->assertForm('http://example.com/two', HttpConstants::POST, $this->fixture->getForm('two'));
    $this->assertForm('/', HttpConstants::GET, $this->fixture->getForm('three'));
  }
}