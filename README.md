# A base testcase for Codeigniter 2.x.x

The class was made for testing Codeigniter using phpunit. You're able to test controllers, models and libraries. 

## Usage

The `example/` directory contains examples of usage.

## Dependencies

- PHP >=5.3.3
- composer

### bootstrap.php
```PHP
<?php
require __DIR__ . '/CITestCase.php';

CITestCase::$system_path = __DIR__ . "/../system";
CITestCase::$app_path = __DIR__ . "/../application";
```

### controllers/welcome.php
```PHP
class WelcomeTest.php extends CITestCase
{
    protected $ci;

    public function setUp()
    {
        parent::setUp();
        require_once APPPATH . 'controllers/welcome.php';
        $this->ci = new Foo();
    }

    public function test_index()
    {
        $this->ci->index();
        $result = $this->ci->output->get_output();

        $this->assertTrue(strlen($result) > 0);
        $this->assertContains('Welcome', $result);
    }

```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)