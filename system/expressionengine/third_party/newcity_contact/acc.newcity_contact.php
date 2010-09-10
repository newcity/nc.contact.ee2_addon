<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Contact NewCity Accessory
 *
 * @package Contact NewCity
 * @author Wes Baker
 */
class Newcity_contact_acc {
    var $name = 'Contact NewCity';
    var $id = 'newcity_acc';
    var $version = '1.0';
    var $description = 'This is an accessory allowing you to get in touch with NewCity.';
    var $sections = array();
	var $extension = 'Newcity_contact_ext';

    /**
     * Constructor
     */
    public function Newcity_contact_acc()
    {
        $this->EE =& get_instance();
    }
    
    
    public function set_sections()
    {
		$settings = $this->get_settings();
		
        $this->sections["Your Contact"]  = $settings['your_contact'];
		if ($settings['enable_bugs'] == 'yes') {
			$this->sections["Bugs &amp; Issues"] = '<p>&bull; <a href="http://bugs.newcityexperience.com/default.php?command=new&pg=pgEditBug" target="_blank">File a bug</a><br />&bull; <a href="http://bugs.newcityexperience.com/default.php?command=new&pg=pgEditBug&sComputer='.urlencode($this->current_page_url()).'" target="_blank">File a bug about <strong>this</strong> page</a></li></ul>';
		}
    }

	private function current_page_url() 
	{
		$pageURL = 'http://';
	 
		if ($_SERVER["SERVER_PORT"] != "80") {
	  		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 	} else {
	  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 	}
	
		// Remove Session Information
		$pageURL = preg_replace('/(S=.*?&)/', '', $pageURL);
	 
		return $pageURL;
	}
	
	private function get_settings($all_sites = FALSE)
	{
		$get_settings = $this->EE->db->query("SELECT settings 
			FROM exp_extensions 
			WHERE class = '".$this->extension."' 
			LIMIT 1");
		
		$this->EE->load->helper('string');
		
		if ($get_settings->num_rows() > 0 && $get_settings->row('settings') != '')
        {
        	$settings = strip_slashes(unserialize($get_settings->row('settings')));
        	$settings = ($all_sites == FALSE && isset($settings[$this->EE->config->item('site_id')])) ? 
        		$settings[$this->EE->config->item('site_id')] : 
        		$settings;
        }
        else
        {
        	$settings = array();
        }

        return $settings;
	}	
	
}

/* End of file acc.newcity_contact.php */
/* Location: ./system/expressionengine/third_party/newcity/acc.newcity_contact.php */ 
