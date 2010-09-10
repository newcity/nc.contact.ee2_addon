<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newcity_contact_ext
{
	var $settings        = array();
	var $name            = 'Contact NewCity Settings';
	var $version         = '1.0';
	var $description     = 'Settings for the Contact NewCity Accessory';
	var $settings_exist  = 'y';
	var $docs_url        = '';
	var $slug			 = 'Newcity_contact_ext';


	function Newcity_contact_ext($settings='')
	{
	    $this->settings = $settings;
	    $this->EE =& get_instance();
	}	
	
	function settings()
	{
		$settings = array();
		
		$settings['your_contact'] = array('t', '8', '');
		$settings['enable_bugs'] = array('r', array('yes' => 'yes', 'no' => 'no'), 'yes');
		
		return $settings;
	}
		
	function activate_extension()
	{

	  $this->EE->db->query($this->EE->db->insert_string('exp_extensions',
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