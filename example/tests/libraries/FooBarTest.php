<?php

class FooBarTest extends CITestCase
{
    protected $ci, $lib;

    public function setUp()
    {
        parent::setUp();

        require_once APPPATH . 'controllers/welcome.php';
        require_once APPPATH . 'libraries/FooBar.php';
        $this->ci = new Welcome();
        $this->lib = new FooBar();
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->ci);
        unset($this->lib);
    }

    public function testBar()
    {
        $this->assertTrue($this->lib->Bar(2) == 4);
        $this->assertTrue($this->lib->Bar() == 2);
    }
}