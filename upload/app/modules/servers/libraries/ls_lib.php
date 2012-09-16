<?php defined('BASEPATH') or exit('No direct script access allowed');

include __DIR__.'/goldsource.php';

/**
 * Live servers library
 * 
 * @package     CStrike-Regnick
 * @subpackage  Module
 * @category    Servers
 * @copyright   2012 Gentle Software Solutions
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2
 * @version     1.0.0
 * @author      Alexandru G. <www.gentle.ro>
 */
class Ls_lib {
    
    public function __construct()
    {        
        if ($this->config->item('cache_path') == APPPATH.'cache')
        {
            $this->config->set_item('cache_path', APPPATH.'cache/');
        }
        $this->load->driver('cache', array('adapter' => 'file'));
        
        $this->load->config('servers/servers', true);

        log_message('debug', 'Ls_lib class initialized');
    }
    
    // ------------------------------------------------------------------------
    
    public function get_info($server)
    {        
        if (is_array($server))
        {
            $ret = '';
            foreach ($server as $s)
            {
                $ret[$s] = $this->get_info($s);
            }
            
            return $ret;
        }
        
        $data   = explode(':', $server);
        $ip     = $data[0];
        $port   = (isset($data[1])) ? $data[1] : 27015;
        unset($data);   
        
        
        if (!$data = $this->cache->get(md5($server).'.cache'))
        {
            $GS = new GoldSource($ip, $port);
            
            // fetch data
            $data = array(
                'request'   => $server,
                'details'   => $GS->get_details(),
                'players'   => $GS->get_players(),
                'error'     => ($GS->is_error()) ? $GS->get_last_error() : 'none' 
            );
            
            $this->cache->save(md5($server).'.cache', $data, (int)$this->config->item('cache_time', 'servers'));
        }
        
        return $data;
    }
    
    public function __get($var)
	{
        return ci()->{$var};
	}
}