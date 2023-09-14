<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'login';
$route['404_override'] = 'not_found';
$route['translate_uri_dashes'] = FALSE;

$route['admin/laporan_transaksi/detail'] = 'cabang/laporan_transaksi/detail';
$route['admin/laporan_dp'] = 'cabang/kasir_dp';
$route['admin/kasir_dp/table'] = 'cabang/kasir_dp/table';
$route['admin/laporan_dp/(:any)'] = 'cabang/kasir_dp/$1';

$route['admin/laporan_refund'] = 'cabang/laporan_refund';
$route['admin/laporan_refund/(:any)'] = 'cabang/laporan_refund/$1';

$route['gudang/dashboard'] = 'cabang/dashboard';
$route['gudang/retur_barang'] = 'cabang/retur_barang';
$route['gudang/retur_barang/(:any)'] = 'cabang/retur_barang/$1';

$route['admin/retur_barang'] = 'cabang/retur_barang';
$route['admin/retur_barang/(:any)'] = 'cabang/retur_barang/$1';

$route['admin/servis_berat'] = 'cabang/servis_berat';
$route['admin/servis_berat/(:any)'] = 'cabang/servis_berat/$1';

$route['admin/operasional'] = 'cabang/operasional';
$route['admin/operasional/(:any)'] = 'cabang/operasional/$1';

$route['admin/cetak/nota_servis_berat/(:any)'] = 'cabang/cetak/nota_servis_berat/$1';

$route['cabang/stock_cabang_lain'] = 'admin/barang/stock_cabang';
$route['cabang/barang/table_stock_cabang'] = 'admin/barang/table_stock_cabang';