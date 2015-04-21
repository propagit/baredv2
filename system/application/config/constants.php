<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

define('TRADE_SITE', 'http://propatest.com/trade_bared');
#define('RETAIL_SITE', 'http://bared.com.au');
define('RETAIL_SITE', 'http://propatest.com/bared');
define('META_TITLE', "Bared Shoes: A revolution in footwear. Men's and women's shoes designed by a podiatrist.");
define('META_DESC', "Bared Footwear aims to design shoes that make you look and feel great. Revolutionising the 'daggy' comfort shoe. ");
define('META_KEYWORDS', 'BARED Footwear');

define('NO_REPLY_EMAIL', 'noreply@bared.com.au');
define('COMPANY_SALES_EMAIL', 'sales@bared.com.au');
define('COMPANY_WEBSITE', 'www.bared.com.au');
define('COMPANY_WEBSITE_LONG', 'http://www.bared.com.au');
define('COMPANY_NAME', 'Bared Footwear');
define('SUB_FOOTER_EMAIL', 'HANDBAGS * LUGGAGE * ACCESSORIES');

define('appId', '380953882022304');
define('secret', '5f772eee9a5ee521244cbc02aa82f688');


define('EMAIL_BCC', 'hans@propagate.com.au,peteryo11@gmail.com');
define('FONT_EMAIL', '<link href="http://fonts.googleapis.com/css?family=Parisienne|Buenard:400,700|Open+Sans:400,600italic,600" rel="stylesheet" type="text/css">');

define("RETAIL_CONFIRMATION_EMAIL_CONTENT", "<p>Dear Glamour Devotee,<br/><br/>

This society has been created for our precious Spencer & Rutherford devotees and all those who adore exquisite handbags, luggage and accessories. You'll love being a part of this beautiful society with its exclusive Spencer & Rutherford offers and exciting rewards.<br/><br/> 
The Divine Society of Glamour Devotees has three glamorous levels.<br/><br/>
Chic Addict<br/><br/><br/>

This is the entry level for those signing up to the Divine Society. Chic Addicts members will enjoy a range of exclusive benefits.<br/><br/> 
Style Queen<br/><br/><br/>

You will enjoy even more wonderful benefits as a Style Queen, including a discount off every purchase. To be eligible for this second level of membership, simply spend $750 in-store or online.<br/><br/> 
Glamour Icon<br/><br/><br/>

The third, and most exclusive level is Glamour Icon, those Divine Society Devotees who spend $2000 or more, will be entitled to move to this level. You will enjoy a fabulous array of benefits including a $50 Spencer & Rutherford gift voucher upon reaching Glamour Icon status and 10% off everything in-store and online.<br/><br/><br/> 

There is just no cure for Spencer & Rutherford bag addiction!<br/><br/>
Don't worry, you needn't lift a finger... The rewards are already heading your way! To learn more about the exciting Divine Society of Glamour Devotees, click here (link) and find out what else we've got in store for you!<br/><br/><br/>
</p>
");


define("TRADE_CONFIRMATION_EMAIL_CONTENT", "<p>Hi %s</p>

<p>Thank you for your application to become a Spencer & Rutherford stockist.<br/>
Your application is currently being reviewed. We will be in contact as soon as this process is complete.
<br/><br>


</p>

<p>Warm Regards,</p>
");
define('ENVIRONMENT', 'development');
define('SALT','br-');

define('PAYPAL_MODE','sandbox');

define('ASSETS','assets/v2/');
# Social Links
define('FACEBOOK','https://facebook.com');
define('TWITTER','https://twitter.com');
define('PINTEREST','https://pinterest.com');
define('INSTAGRAM','https://instagram.com');
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./system/application/config/constants.php */