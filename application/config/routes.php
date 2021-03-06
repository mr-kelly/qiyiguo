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
$route['scaffolding_trigger'] = "";




// Group
$route['g/(:any)'] = 'group/group_lookup/$1';
$route['group/(:num)'] = 'group/group_lookup/$1';
$route['group/(:num)/(:any)'] = 'group/group_lookup/$1/$2';

// User
$route['u/(:any)'] = 'user/user_lookup/$1';
$route['user/(:num)'] = 'user/user_lookup/$1';
$route['user/(:num)/(:any)'] = 'user/user_lookup/$1/$2';

// Page
$route['page/(:any)'] = 'page/page_lookup/$1';



// Topic
$route['topic/(:num)'] = 'topic/topic_lookup/$1';

// Event
$route['event/(:num)'] = 'event/event_lookup/$1';




// 果园
$route['orchard/'] = 'orchard/home/index';
$route['orchard/group/(:num)'] = 'orchard/group/group_lookup/$1';



/* End of file routes.php */
/* Location: ./system/application/config/routes.php */
