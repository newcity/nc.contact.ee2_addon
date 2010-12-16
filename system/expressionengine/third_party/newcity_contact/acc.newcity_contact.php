<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD.'newcity_contact/config.php';

/**
 * The Contact NewCity Accessory
 *
 * @package Contact NewCity
 * @author Wes Baker
 */
class Newcity_contact_acc {
	var $name        = NC_CONTACT_NAME;
	var $version     = NC_CONTACT_VER;
	var $description = NC_CONTACT_DESC;
	var $sections    = array();
	var $id          = 'newcity_acc';
	
	var $default_settings = array(
		"your_contact" => "",
		"enable_bugs" => "no"
	);

	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	public function set_sections()
	{
		$settings = $this->get_settings();
		
		$this->sections["Your Contact"]	 = $settings['your_contact'];
		if ($settings['enable_bugs'] == 'yes') {
			$this->sections["Bugs &amp; Issues"] = '<p>&bull; <a href="http://bugs.newcityexperience.com/default.php?command=new&pg=pgEditBug" target="_blank">File a bug</a><br />&bull; <a href="http://bugs.newcityexperience.com/default.php?command=new&pg=pgEditBug&sComputer='.urlencode($this->current_page_url()).'" target="_blank">File a bug about <strong>this</strong> page</a></p>';
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
	
	private function get_settings()
	{
		$this->EE->load->helper('string');
		
		// Pull in the serialized settings and unserialize them
		$get_settings = unserialize(
			$this->EE->db
				->select('settings')
				->limit(1)
				->get_where('extensions', array("class" => "Newcity_contact_ext"))
				->row('settings')
		);
		
		return ($get_settings != '') ? $get_settings : $this->default_settings;
	}	
	
}

/* End of file acc.newcity_contact.php */
/* Location: ./system/expressionengine/third_party/newcity/acc.newcity_contact.php */ 
