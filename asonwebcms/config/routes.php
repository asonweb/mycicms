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

$route['default_controller'] = "index";
$route['404_override'] = '';

$route['admin/content'] = "admin/content/index/type/doc";
$route['admin/content/index'] = "admin/content/index/type/doc";
$route['admin/content/index/(:any)'] = "admin/content/index/type/$1";

//add action insert action
$route['admin/content/add/(:any)'] = "admin/content/add/type/$1";
$route['admin/content/insert/(:any)'] = "admin/content/insert/type/$1";
//edit action update action
$route['admin/content/edit/(:any)/(:any)'] = "admin/content/edit/type/$1/id/$2";
$route['admin/content/update/(:any)'] = "admin/content/update/type/$1";
//delete action
$route['admin/content/delete/(:num)'] = "admin/content/delete/$1";
//分类列表
$route['admin/category/index/(:any)'] = "admin/category/index/type/$1";
//分类表单 编辑、新增

$route['admin/category/form/(:any)/(:num)'] = "admin/category/form/type/$1/id/$2";
$route['admin/category/form/(:any)'] = "admin/category/form/type/$1";
//添加子类
$route['admin/category/parent/(:any)/(:num)'] = "admin/category/parent/type/$1/pid/$2";
/* End of file routes.php */
/* Location: ./application/config/routes.php */