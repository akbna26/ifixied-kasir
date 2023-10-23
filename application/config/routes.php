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

$route['owner_cabang/dashboard'] = 'owner/dashboard';
$route['owner_cabang/daftar_cabang'] = 'owner/daftar_cabang';
$route['owner_cabang/daftar_cabang/detail/(:any)'] = 'owner/daftar_cabang/detail/$1';
$route['owner_cabang/daftar_cabang/(:any)'] = 'owner/daftar_cabang/$1';

$route['servis/servis_berat'] = 'cabang/servis_berat';
$route['servis/cetak/nota_servis_berat/(:any)'] = 'cabang/cetak/nota_servis_berat/$1';
$route['servis/servis_berat/(:any)'] = 'cabang/servis_berat/$1';

$route['admin/kasbon'] = 'cabang/kasbon';
$route['admin/kasbon/(:any)'] = 'cabang/kasbon/$1';

$route['cs/stock_cabang_lain'] = 'admin/barang/stock_cabang';
$route['cs/barang/table_stock_cabang'] = 'admin/barang/table_stock_cabang';

$route['admin/laporan_modal'] = 'cabang/laporan_modal';
$route['admin/laporan_modal/table'] = 'cabang/laporan_modal/table';
$route['admin/laporan_modal/(:any)'] = 'cabang/laporan_modal/$1';

$route['admin/kerugian'] = 'cabang/kerugian';
$route['admin/kerugian/table'] = 'cabang/kerugian/table';
$route['admin/kerugian/(:any)'] = 'cabang/kerugian/$1';

$route['admin/setor_tunai'] = 'cabang/setor_tunai';
$route['admin/setor_tunai/table'] = 'cabang/setor_tunai/table';
$route['admin/setor_tunai/(:any)'] = 'cabang/setor_tunai/$1';

$route['accounting/dashboard'] = 'cabang/dashboard';

$route['accounting/sirkulasi_part'] = 'gudang/sirkulasi_part';
$route['accounting/sirkulasi_part/table'] = 'gudang/sirkulasi_part/table';
$route['accounting/sirkulasi_part/(:any)'] = 'gudang/sirkulasi_part/$1';

$route['accounting/sirkulasi_acc'] = 'gudang/sirkulasi_acc';
$route['accounting/sirkulasi_acc/table'] = 'gudang/sirkulasi_acc/table';
$route['accounting/sirkulasi_acc/(:any)'] = 'gudang/sirkulasi_acc/$1';

$route['accounting/laporan_modal'] = 'cabang/laporan_modal';
$route['accounting/laporan_modal/table'] = 'cabang/laporan_modal/table';
$route['accounting/laporan_modal/(:any)'] = 'cabang/laporan_modal/$1';

$route['accounting/laporan_transaksi'] = 'admin/laporan_transaksi';
$route['accounting/laporan_transaksi/(:any)'] = 'admin/laporan_transaksi/$1';

$route['accounting/laporan_dp'] = 'cabang/kasir_dp';
$route['accounting/kasir_dp/table'] = 'cabang/kasir_dp/table';
$route['accounting/cetak/nota_dp/(:any)'] = 'cabang/cetak/nota_dp/$1';
$route['accounting/laporan_dp/(:any)'] = 'cabang/kasir_dp/$1';

$route['accounting/paylater'] = 'admin/paylater';
$route['accounting/paylater/(:any)'] = 'admin/paylater/$1';

$route['accounting/kasbon'] = 'cabang/kasbon';
$route['accounting/kasbon/(:any)'] = 'cabang/kasbon/$1';

$route['accounting/setor_tunai'] = 'cabang/setor_tunai';
$route['accounting/setor_tunai/(:any)'] = 'cabang/setor_tunai/$1';

$route['accounting/modal_awal'] = 'admin/modal_awal';
$route['accounting/modal_awal/(:any)'] = 'admin/modal_awal/$1';

$route['accounting/cancel_transaksi'] = 'admin/cancel_transaksi';
$route['accounting/cancel_transaksi/(:any)'] = 'admin/cancel_transaksi/$1';

$route['accounting/cancel_servis'] = 'admin/cancel_servis';
$route['accounting/cancel_servis/(:any)'] = 'admin/cancel_servis/$1';

$route['gudang/barang'] = 'admin/barang';
$route['gudang/barang/(:any)'] = 'admin/barang/$1';

$route['gudang/barang_restock'] = 'admin/barang_restock';
$route['gudang/barang_restock/(:any)'] = 'admin/barang_restock/$1';

$route['gudang/barang_sharing'] = 'admin/barang_sharing';
$route['gudang/barang_sharing/(:any)'] = 'admin/barang_sharing/$1';

$route['gudang/barang_sharing_detail'] = 'admin/barang_sharing_detail';
$route['gudang/barang_sharing_detail/(:any)/(:any)'] = 'admin/barang_sharing_detail/$1/$2';
$route['gudang/barang_sharing_detail/(:any)'] = 'admin/barang_sharing_detail/$1';
$route['gudang/cetak/detail_sharing/(:any)'] = 'admin/cetak/detail_sharing/$1';