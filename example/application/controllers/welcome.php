<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    protected $content_type;
    protected $json;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Welcome_model');
    }

    /**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

    public function salute($greeting = '')
    {
        $result = $this->load->view(
            'welcome_message',
            array('greeting' => $greeting),
            true
        );

        echo $this->saluteJson($result);
    }

    public function saluteJson($result)
    {
        $content_type = $this->input->get_request_header(
            'Content-type', true);

        if ($content_type == 'application/json') {
            $model_data = $this->Welcome_model->get_data();

            return json_encode(array(
                'html' => $result,
                'model_data' => $model_data
            ));
        }

        return $result;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */