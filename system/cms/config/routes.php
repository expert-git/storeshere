<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']                = 'pages';
$route['404_override']                      = 'pages';

$route['admin/help/([a-zA-Z0-9_-]+)']       = 'admin/help/$1';
$route['admin/([a-zA-Z0-9_-]+)/(:any)']	    = '$1/admin/$2';

$route['admin/(login|logout|remove_installer_directory)']			    = 'admin/$1';

$route['admin/([a-zA-Z0-9_-]+)']            = '$1/admin/index';

$route['api/ajax/(:any)']          			= 'api/ajax/$1';
$route['api/([a-zA-Z0-9_-]+)/(:any)']	    = '$1/api/$2';
$route['api/([a-zA-Z0-9_-]+)']              = '$1/api/index';

$route['register']                          = 'users/register';
$route['ressend_email']                          = 'users/ressend_email';
$route['user/(:any)']	                    = 'users/view/$1';
$route['my-profile']	                    = 'users/index';
$route['edit-profile']	                    = 'users/edit';

$route['sitemap.xml']                       = 'sitemap/xml';
$route['editPhotos/(:any)']					= 'users/stores/editPhotos/$1';
$route['sendPhotos/(:any)']                 = 'users/stores/sendPhotos/$1';

/* End of file routes.php */

/** More Routes **/
$route['signup']                            = 'users/stores/signUp';
$route['signup/(:any)']                     = 'users/stores/signUp/$1';
$route['signup_success/(:any)']             = 'users/stores/signup_success/$id';
$route['signup_mobile/(:any)']             = 'users/stores/signup_mobile/$id';
$route['sendFunds']                         = 'users/stores/sendFunds';
$route['contact']                           = 'users/stores/contact';
$route['verifyOTP']                           = 'users/stores/verifyOTP';
$route['profile']                           = 'users/stores/profile';
$route['aboutUs']                           = 'users/stores/aboutUs';
$route['sendPhotos']                        = 'users/stores/sendPhotos';
$route['updateProfile']                     = 'users/stores/updateProfile';
$route['setPassword']                       = 'users/stores/setPassword';
$route['addInmates']                        = 'users/stores/addInmates';
$route['updatePassword']                    = 'users/stores/updatePassword';
$route['getCaptcha']                   		= 'users/stores/generateCaptcha';
$route['getFacilityInmates']				= 'users/stores/getFacilityInmates';
$route['addImage']				            = 'users/stores/addImage';
$route['payThroughGenie']				    = 'users/stores/payThroughGenie';
$route['genieSuccess']				    	= 'users/stores/genieSuccess';
$route['genie_success']				    	= 'users/stores/genie_success';
$route['payThroughPaypal']				    = 'users/stores/payThroughPaypal';
$route['paypal_success']				    = 'users/stores/paypal_success';
$route['paypal_cancel']				        = 'users/stores/paypal_cancel';
$route['paypal_notify']				        = 'users/stores/paypal_notify';
$route['uploadPhotos']				        = 'users/stores/uploadPhotos';
$route['upload_photos']				        = 'users/stores/upload_photos';
$route['paypalSuccess']				        = 'users/stores/paypalSuccess';
$route['getImagesFromId']				    = 'users/stores/getImagesFromId';
$route['getSentPhotosListing']				= 'users/stores/getSentPhotosListing';
$route['deleteInmate']     				    = 'users/stores/deleteInmate';
$route['deleteImage']     				    = 'users/stores/deleteImage';
$route['phoneImages']     				    = 'users/stores/phoneImages';
$route['editInmate/(:num)']   			    = 'users/stores/editInmate/$1';
$route['updateInmate']   			        = 'users/stores/updateInmate';
$route['testing']   			            = 'users/stores/testing';
$route['loginSuccess']                      = 'users/stores/loginSuccess';
$route['editPhotos']                        = 'users/stores/editPhotos';
$route['saveImageToLibrary']   			    = 'users/stores/saveImageToLibrary';
$route['fundingOptions']   			    	= 'users/stores/fundingOptions';

// load pages on left navigation
$route['change_pass']   			        = 'users/stores/change_pass';
$route['add_inmate']   			            = 'users/stores/add_inmate';
$route['inmate_list']   			        = 'users/stores/inmate_list';
$route['photos_sent']   			        = 'users/stores/photos_sent';
$route['funds_sent']   			            = 'users/stores/funds_sent';
$route['checkUser']                         = 'users/checkUser';
$route['checkEmail']                        = 'users/checkEmail';
//$route['verifyOTP']                        = 'users/verifyOTP';
