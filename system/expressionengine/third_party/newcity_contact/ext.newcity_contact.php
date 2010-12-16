<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD.'newcity_contact/config.php';

class Newcity_contact_ext
{
	var $name           = NC_CONTACT_NAME;
	var $version        = NC_CONTACT_VER;
	var $description    = NC_CONTACT_DESC;
	var $settings_exist = 'y';
	var $docs_url       = NC_CONTACT_DOCS;

	function __construct($settings='')
	{
	    $this->settings = $settings;
	    $this->EE =& get_instance();
	}	
	
	function settings()
	{
		$settings = array();
		
		$default_contact = "<h3>Project Manager</h3>\n<p>\n\t<a href='mailto:project_manager@insidenewcity.com'>project_manager@insidenewcity.com</a><br />\n\t540-552-1320 extension 2xx\n</p>";
		
		$settings['your_contact'] = array('t', '8', $default_contact);
		$settings['enable_bugs'] = array('r', array('yes' => 'yes', 'no' => 'no'), 'yes');
		
		return $settings;
	}
		
	function activate_extension()
	{
		$this->EE->db->insert(
			'extensions',
			array(
				'extension_id' => '',
				'class'        => ucfirst(get_class($this)),
				'method'       => '',
				'hook'         => '',
				'settings'     => '',
				'priority'     => 10,
				'version'      => $this->version,
				'enabled'      => "y"
			)
		);
	}

	function update_extension($current='')
	{
	    if ($current == '' OR $current == $this->version)
	    {
	        return FALSE;
	    }
	    
		$this->EE->db->query("UPDATE exp_extensions 
	     	SET version = '". $this->EE->db->escape_str($this->version)."' 
	     	WHERE class = '".ucfirst(get_class($this))."'");
	}

	
	function disable_extension()
	{	    
		$this->EE->db->query("DELETE FROM exp_extensions WHERE class = '".ucfirst(get_class($this))."'");
	}

}