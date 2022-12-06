<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ruta pentru crearea posturilor
$route['posts/create'] = 'posts/create';
// ruta pentru editarea posturilor (submit btn)
$route['posts/update'] = 'posts/update';
// ruta pentru posturi individuale
$route['posts/(:any)'] = 'posts/view/$1';
// ruta pentru toate posturile
$route['posts'] = 'posts/index';

// setare controller default
$route['default_controller'] = 'pages/view';

// ruta pentru toate categoriile
$route['categories'] = 'categories/index';
// ruta pentru crearea categoriilor
$route['categories/create'] = 'categories/create';
// ruta pentru categorii individuale
$route['categories/posts/(:any)'] = 'categories/posts/$1';

// ruta pentru pagini 
$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
