<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| 	example.com/class/method/id/
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
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

$route['default_controller'] = "home";
$route['admin'] = "admin/cms/only_admin";
$route['admin/login'] = "admin/authorize/login";
$route['admin/logout'] = "admin/authorize/logout";
$route['admin/validate'] = "admin/authorize/validate";
$route['scaffolding_trigger'] = "";

$route['store/stories_new/(:any)/(:num)'] = "store/stories/$1/$2";
$route['page/(:any)']="store/pages/$1";
$route['shoe-features/16/Frequently-Asked-Questions'] = 'store/pages/FAQ';
$route['contact'] = 'store/pages/Contact-Us';
$route['store/category/4'] = 'store/products/Womens/sandals';
$route['shoe-features/11/Tips-for-Fitting-Tricky-Feet'] = 'store/page/37';
$route['store/category/9'] = 'store/products/sale/all';
$route['store/category/1'] = 'store/products/Womens/all-shoes';


$route['gallery'] = 'store/gallery/all';



/* End of file routes.php */
/* Location: ./system/application/config/routes.php */