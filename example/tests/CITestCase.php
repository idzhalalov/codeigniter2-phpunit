<?php

use \PHPUnit\Framework\TestCase;


class CITestCase extends TestCase
{
    public static $system_path, $app_path;

    public static function setupBeforeClass()
    {
        parent::setupBeforeClass();

        if (!defined('BASEPATH')) {
            if (empty(static::$system_path)) {
                throw new Exception('---> '.__CLASS__
                    .'::$system_path is not defined');
            }
            if (empty(static::$app_path)) {
                throw new Exception('---> '.__CLASS__
                    .'::$app_path is not defined');
            }
            static::initPaths(
                static::$system_path,
                static::$app_path
            );
        }
    }

    public function setUp()
    {
        parent::setUp();
        $this->iniApp();
    }

    public function tearDown()
    {
        parent::tearDown();
        $ci = get_instance();
        $ci->config = null;
        $ci->input = null;
        $ci->output = null;
    }

    public static function initPaths($system_path = '', $app_path)
    {
        // Set the current directory correctly for CLI requests
        if (defined('STDIN')) {
            chdir(dirname(__FILE__));
        }
        if (realpath($system_path) !== false) {
            $system_path = realpath($system_path).'/';
        }

        // ensure there's a trailing slash
        $system_path = rtrim($system_path, '/').'/';

        // Is the system path correct?
        if ( ! is_dir($system_path)) {
            exit("Your system folder path does not appear to be set correctly. 
                  Please open the following file and correct this: "
                .pathinfo(__FILE__, PATHINFO_BASENAME));
        }

        // The name of THIS file
        define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

        // The PHP file extension
        // this global constant is deprecated.
        define('EXT', '.php');

        // Path to the system folder
        define('BASEPATH', str_replace("\\", "/", $system_path));

        // Path to the front controller (this file)
        define('FCPATH', str_replace(SELF, '', __FILE__));

        // Name of the "system folder"
        define('SYSDIR',
            trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

        // The path to the "application" folder
        if (is_dir($app_path)) {
            define('APPPATH', $app_path.'/');
        } else {
            if ( ! is_dir(BASEPATH.$app_path.'/')) {
                exit("Your application folder path does not appear to be set correctly. 
              Please open the following file and correct this: "
                    .SELF);
            }
            define('APPPATH', BASEPATH.$app_path.'/');
        }
    }

    public function iniApp()
    {
        // Necessary libs
        require_once BASEPATH.'core/Common.php';

        // Load constants
        if (defined('ENVIRONMENT')
            AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/constants.php')
        ) {
            require_once APPPATH.'config/'.ENVIRONMENT.'/constants.php';
        } else {
            require_once APPPATH.'config/constants.php';
        }

        // Set the subclass_prefix
        if (isset($assign_to_config['subclass_prefix'])
            AND $assign_to_config['subclass_prefix'] != ''
        ) {
            get_config(array('subclass_prefix' => $assign_to_config['subclass_prefix']));
        }

        // Init globals
        $CFG =& load_class('Config', 'core');
        $GLOBALS['CFG'] = $CFG;
        $UNI =& load_class('Utf8', 'core');
        $GLOBALS['UNI'] = $UNI;
        $SEC =& load_class('Security', 'core');
        $GLOBALS['SEC'] = $SEC;
        load_class('Input', 'core');
        load_class('Output', 'core');

        require_once BASEPATH.'core/Controller.php';
    }
}

function &get_instance()
{
    return CI_Controller::get_instance();
}
