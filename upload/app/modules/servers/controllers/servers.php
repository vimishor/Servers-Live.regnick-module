<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This file is part of the CStrike-Regnick package
 * 
 * (c) Gentle Software Solutions <www.gentle.ro>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// ------------------------------------------------------------------------

/**
 * Server controller
 * 
 * Provides servers listing
 * 
 * @package     CStrike-Regnick
 * @category    Controllers
 * @copyright   (c) 2011 - 2012 Gentle Software Solutions
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @link        http://www.gentle.ro/ 
 */
class Servers extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // load module dependencies
        $this->load->language('servers_live');
        $this->load->library('ls_lib');
        
        // setup module custom assets
        $append = (!is_dev()) ? '.min' : '';
        $this->template->module_assets = base_url('pub/storage/servers_live');
        $this->template->append_metadata('<link href="'. $this->template->module_assets .'/css/servers_live'.$append.'.css" rel="stylesheet">');
        $this->template->append_metadata('<script src="'. $this->template->module_assets .'/js/servers_live'.$append.'.js"></script>');
    }

    /**
     * Fetch server info from ajax request
     * 
     * @access  public
     * @param   string  $server
     * @return  void
     */
    public function fetch($server)
    {
        if (!is_dev())
        {
            if (!$this->input->is_ajax_request())
            {
                die('invalid request');
            }
        }
        
        if (is_dev())
        {
            $this->output->enable_profiler(FALSE);
        }
        $live = $this->ls_lib->get_info($server);
        
        echo json_encode($live);
    }

    /**
     * Output page
     * 
     * @see     index()
     * @access  public
     * @param   int     $page   Page number
     * @return  void
     */
    public function show($page = 0)
    {
        $this->load->model('server_model');
        $this->load->library('pagination');
        
        // + pagination config
        $config['base_url']     = site_url('servers/show');
        $config['total_rows']   = $this->db->where('ID >', DEFAULT_SERVER_ID)->count_all_results('servers');
        $config['per_page']     = $this->config->item('results_per_page');
        $config['uri_segment']  = 3;
        $this->pagination->initialize($config);
        // - pagination config 
        
        $servers = $this->server_model->getServers(false, $config['per_page'], $page);
                
        $data = array(
            'page_title'    => lang('community_servers'),
            'page_subtitle' => lang('enjoy_playing'),
            'servers'       => $servers,
        );
        
        $this->template->set_layout('one_col')->build('list', $data);
    }

    /**
     * Output page alias
     * 
     * @see     show()
     * @access  public
     * @param   int     $page   Page number
     * @return  void
     */
    public function index($page = 0)
    {
        $this->show($page);
    }
}