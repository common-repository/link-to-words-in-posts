<?php 

/*Plugin Name:Links to Keywords

Plugin URI: http://www.socialbullets.com

Description: This is a Simple Plugin for Adding links to Reoccuring Keywords of your choice to any wordpress post from a simple panel at once.

Author: Arsalan Ahmed 

Version: 1.0

Author URI: http://www.socialbullets.com

*/  	
global $wpdb;

 

 	function keywords_vulcun_admin() 
		{
			include('keywords_vulcun_admin_page.php');
		}

		function keywords_vulcun_actions() 
		{
			add_options_page("Keywords Linking", "Keywords Linking", 1, "manage_keywords", "keywords_vulcun_admin");
		 
		}

		add_action('admin_menu', 'keywords_vulcun_actions');
	

?>