# A base testcase for Codeigniter 2.x.x

The class was made for testing Codeigniter using phpunit. You're able to test controllers, models and libraries. 

## Dependencies

- PHP >=5.3.3
- composer

## Usage

### TL;DR

The `example/` directory contains examples of usage.

### Bootstrap

#### /tests/bootstrap.php
```PHP
<?php
require __DIR__ . '/CITestCase.php';

CITestCase::$system_path = __DIR__ . "/../system";
CITestCase::$app_path = __DIR__ . "/../application";
```


### Testing a controller and a model

#### tests/controllers/WelcomeTest.php
```PHP
class WelcomeTest.php extends CITestCase
{
    protected $ci;

    public function setUp()
    {
        parent::setUp();
        require_once APPPATH . 'controllers/welcome.php';
        $this->ci = new Welcome();
    }

    public function test_index()
    {
        $this->ci->index();
        $result = $this->ci->output->get_output();

        $this->assertTrue(strlen($result) > 0);
        $this->assertContains('Welcome', $result);
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
```

### Testing a library

#### /tests/libraries/FooBarTest.php
```PHP
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

    public function testBar()
    {
        $this->assertTrue($this->lib->Bar(2) == 4);
        $this->assertTrue($this->lib->Bar() == 2);
    }
}
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)