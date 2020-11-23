<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Order extends Module {

public $version = '2.0';

public function info()
{
	return array(
		'name' => array(
			'en' => 'Order'
		),
		'description' => array(
			'en' => 'Allows admin to view Orders.'
		),
		'frontend' => false,
		'backend'  => TRUE,
		'menu' => 'Order'
	);
}

public function admin_menu(&$menu)
{	
		
 $user=$this->current_user->group_id;
 
 if ($user == 3) 
 {
        $menu['Orders'] = array('Fund Orders' => 'admin/order');
 }
 else{
         $menu['Orders'] = array('Fund Orders' => 'admin/order','Photo Orders' => 'admin/order/photoOrders');
    }
 
}

public function install()
{
	return TRUE;
}

public function uninstall()
{
	return TRUE;
}

public function upgrade($old_version)
{
	return TRUE;
}

}
/* End of file details.php */