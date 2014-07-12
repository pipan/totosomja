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
| There area two reserved routes:
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
/*
 * routes for admin version
 */
$route['admin/profile/(:any)'] = "admin/profile/$1";
$route['admin/profile'] = "admin/profile";
$route['admin/blog_series/(:any)'] = "admin/blog_series/$1";
$route['admin/blog_series'] = "admin/blog_series";
$route['admin/blog/(:any)'] = "admin/blog/$1";
$route['admin/blog'] = "admin/blog";
$route['admin/category/(:any)'] = "admin/category/$1";
$route['admin/category'] = "admin/category";
$route['admin/type/(:any)'] = "admin/type/$1";
$route['admin/type'] = "admin/type";
$route['admin/supplier/(:any)'] = "admin/supplier/$1";
$route['admin/supplier'] = "admin/supplier";
$route['admin/material/(:any)'] = "admin/material/$1";
$route['admin/material'] = "admin/material";
$route['admin/size/(:any)'] = "admin/size/$1";
$route['admin/size'] = "admin/size";
$route['admin/color/(:any)'] = "admin/color/$1";
$route['admin/color'] = "admin/color";
$route['admin/product/(:any)'] = "admin/product/$1";
$route['admin/product'] = "admin/product";
$route['admin/manager/(:any)'] = "admin/manager/$1";
$route['admin/manager'] = "admin/manager";
/*
 * routes for system version
 */
$route['admin/system/(:any)'] = "admin/system/$1";
$route['admin/system'] = "admin/system";

$route['admin/(:any)'] = "admin//$1";
$route['admin'] = "admin/manager";

/*
 * routes for customer
 */
//blog
$route['(:any)/blog/(:num)'] = "customer/blog/index/$2/$1";
$route['(:any)/blog/tag/(:num)/(:any)'] = "customer/blog/tag/$3/$2/$1";
$route['(:any)/blog/tag/(:any)'] = "customer/blog/tag/$2/$1";
$route['(:any)/blog/(:any)'] = "customer/blog/view/$2/$1";
$route['(:any)/blog'] = "customer/blog/index/1/$1";
$route['blog/(:num)'] = "customer/blog/index/$1";
$route['blog/(:any)'] = "customer/blog/view/$1";
$route['blog'] = "customer/blog/index";
//shirt
$route['(:any)/shirt/(:num)/(:any)'] = "customer/shirt/index/$2/$1/$3";
$route['(:any)/shirt/(:num)'] = "customer/shirt/index/$2/$1";
$route['(:any)/shirt/wish/(:any)'] = "customer/shirt/wish/$2/$1";
$route['(:any)/shirt/(:any)'] = "customer/shirt/view/$2/$1";
$route['(:any)/shirt'] = "customer/shirt/index/1/$1";
$route['shirt/(:num)/(:any)'] = "customer/shirt/index/$1/$2";
$route['shirt/(:num)'] = "customer/shirt/index/$1";
$route['shirt/(:any)'] = "customer/shirt/view/$1";
$route['shirt'] = "customer/shirt/index";
//registration
$route['(:any)/login/(:any)'] = "customer/login/$2/$1";
$route['login/(:any)'] = "customer/login/$2";
//login
$route['(:any)/login'] = "customer/login/index/$1";
$route['login'] = "customer/login";
//profile
$route['(:any)/profile/wishlist/(:any)/(:number)'] = "customer/profile/$2/$3/$1";
$route['(:any)/profile/(:any)'] = "customer/profile/$2/$1";
$route['profile/(:any)'] = "customer/profile/$1";
$route['(:any)/profile'] = "customer/profile/index/$1";
$route['profile'] = "customer/profile";

$route['(:any)'] = "customer/shop/index/$1";
$route['default_controller'] = "customer/shop";
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */