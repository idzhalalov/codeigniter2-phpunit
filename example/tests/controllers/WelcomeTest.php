<?php
class WelcomeTest extends CITestCase
{
    protected $ci;

    public function setUp()
    {
        parent::setUp();
        require_once APPPATH . 'controllers/welcome.php';
        $this->ci = new Welcome();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testWelcome()
    {
        $this->ci->index();
        $result = $this->ci->output->get_output();

        $this->assertTrue(strlen($result) > 0);
        $this->assertContains('Welcome', $result);
    }

    public function testSalute()
    {
        $greetings = 'Hi there';

        ob_start();
        $this->ci->salute($greetings);
        $result = ob_get_clean();

        $this->assertContains($greetings, $result);
    }


    public function testSaluteAsJson()
    {
        $greetings = 'Hi there';
        $_SERVER['CONTENT_TYPE'] = 'application/json';

        ob_start();
        $this->ci->salute($greetings);
        $result = json_decode(ob_get_clean(), true);

        $this->assertTrue(gettype($result) == 'array');
        $this->assertContains($greetings, $result['html']);
    }


    public function testSaluteModelData()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/json';

        ob_start();
        $this->ci->salute();
        $result = json_decode(ob_get_clean(), true);

        $this->assertArrayHasKey('model_data', $result);
        $this->assertTrue(
            gettype($result['model_data']) == 'array'
        );
    }
}