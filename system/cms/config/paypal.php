<?php  

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/** 

 * Sandbox / Test Mode

 * -------------------------

 * TRUE means you'll be hitting PayPal's sandbox/test servers.  FALSE means you'll be hitting the live servers.

 */

$config['Sandbox'] = FALSE;



/* 

 * PayPal API Version

 * ------------------

 * The library is currently using PayPal API version 98.0.  

 * You may adjust this value here and then pass it into the PayPal object when you create it within your scripts to override if necessary.

 */

$config['APIVersion'] = '123.0'; //'98.0';



/*

 * PayPal Gateway API Credentials

 * ------------------------------

 * These are your PayPal API credentials for working with the PayPal gateway directly.

 * These are used any time you're using the parent PayPal class within the library.

 * 

 * We're using shorthand if/else statements here to set both Sandbox and Production values.

 * Your sandbox values go on the left and your live values go on the right.

 * 

 * You may obtain these credentials by logging into the following with your PayPal account: https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-api-run

 */

// $config['APIUsername'] = $config['Sandbox'] ? 'testing_account435_api1.gmail.com' : 'PRODUCTION_USERNAME_GOES_HERE';

// $config['APIPassword'] = $config['Sandbox'] ? '9BDUNF8SMN3ZHDQ2' : 'PRODUCTION_PASSWORD_GOES_HERE';

// $config['APISignature'] = $config['Sandbox'] ? 'AFcWxV21C7fd0v3bYYYRCpSSRl31AE.4GnpY49ne5DF822URlEDlfdQz' : 'PRODUCTION_SIGNATURE_GOES_HERE';

$config['APIUsername'] = $config['Sandbox'] ? 'business.devpatidar1224_api1.gmail.com' : 'ron_api1.ronniecase.com';

$config['APIPassword'] = $config['Sandbox'] ? 'C8PUH2W3YZGYJACX' : 'QSBLGUG2NRTVBKWE';

$config['APISignature'] = $config['Sandbox'] ? 'AFcWxV21C7fd0v3bYYYRCpSSRl31A3TQye.sXKoXZqKbn5Kwk.X2R1FY' : 'AFcWxV21C7fd0v3bYYYRCpSSRl31Aw0T6vNKa9NJbatMxzqjMv7TKTqF';

// $config['APIUsername'] = $config['Sandbox'] ? 'pravesh_b_a_api1.gmail.com' : 'PRODUCTION_USERNAME_GOES_HERE';

//  $config['APIPassword'] = $config['Sandbox'] ? '1406277424' : 'PRODUCTION_PASSWORD_GOES_HERE';

//  $config['APISignature'] = $config['Sandbox'] ? 'AFcWxV21C7fd0v3bYYYRCpSSRl31Aud5edZcta612G.iXYy6162QHhZm' : 'PRODUCTION_SIGNATURE_GOES_HERE';

/*

 * Payflow Gateway API Credentials

 * ------------------------------

 * These are the credentials you use for your PayPal Manager:  http://manager.paypal.com

 * These are used when you're working with the PayFlow child class.

 * 

 * We're using shorthand if/else statements here to set both Sandbox and Production values.

 * Your sandbox values go on the left and your live values go on the right.

 * 

 * You may use the same credentials you use to login to your PayPal Manager, 

 * or you may create API specific credentials from within your PayPal Manager account.

 */

$config['PayFlowUsername'] = $config['Sandbox'] ? 'SANDBOX_USERNAME_GOES_HERE' : 'PRODUCTION_USERNAME_GOGES_HERE';

$config['PayFlowPassword'] = $config['Sandbox'] ? 'SANDBOX_PASSWORD_GOES_HERE' : 'PRODUCTION_PASSWORD_GOES_HERE';

$config['PayFlowVendor'] = $config['Sandbox'] ? 'SANDBOX_VENDOR_GOES_HERE' : 'PRODUCTION_VENDOR_GOES_HERE';

$config['PayFlowPartner'] = $config['Sandbox'] ? 'SANDBOX_PARTNER_GOES_HERE' : 'PRODUCTION_PARTNER_GOES_HERE';



/*

 * PayPal Application ID

 * --------------------------------------

 * The application is only required with Adaptive Payments applications.

 * You obtain your application ID but submitting it for approval within your 

 * developer account at http://developer.paypal.com

 *

 * We're using shorthand if/else statements here to set both Sandbox and Production values.

 * Your sandbox values go on the left and your live values go on the right.

 * The sandbox value included here is a global value provided for developrs to use in the PayPal sandbox.

 */

$config['ApplicationID'] = $config['Sandbox'] ? 'access_token$sandbox$jd8ppzqdv7qvjb4f$536f0e39707775fda7c2825056a17627' : 'PRODUCTION_APP_ID_GOES_HERE';



/*

 * PayPal Developer Account Email Address

 * This is the email address that you use to sign in to http://developer.paypal.com

 */

$config['DeveloperEmailAccount'] = 'business.devpatidar1224@gmail.com';



/**

 * Third Party User Values

 * These can be setup here or within each caller directly when setting up the PayPal object.

 */

$config['DeviceID'] = 'DEVICE_ID_GOES_HERE';



/* End of file paypal.php */

/* Location: ./system/application/config/paypal.php */

