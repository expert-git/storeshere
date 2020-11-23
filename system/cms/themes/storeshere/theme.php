<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Storeshere extends Theme {

    public $name			= 'Storeshere Theme';
    public $author			= 'Hammdadi shah';
    public $author_website	= 'http://samosys.com/';
    public $website			= 'http://storeshere.com/';
    public $description		= 'Storeshere theme developed by samosys.';
    public $version			= '1.0.0';
	public $options 		= array('show_breadcrumbs' => 	array('title' 		=> 'Show Breadcrumbs',
																'description'   => 'Would you like to display breadcrumbs?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => true),
									'layout' => 			array('title' => 'Layout',
																'description'   => 'Which type of layout shall we use?',
																'default'       => '2 column',
																'type'          => 'select',
																'options'       => '2 column=Two Column|full-width=Full Width|full-width-home=Full Width Home Page',
																'is_required'   => true),
								   );
}

/* End of file theme.php */
