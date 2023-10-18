<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Query_global extends CI_Model
{

    public function modal()
    {
        $penjualan_1 = "SELECT a.id_cabang, a.created as tanggal,'PENJUALAN' as jenis_transaksi, (a.bayar - (a.potongan+(case when a.id_jenis_pembayaran=2 then a.kembalian else 0 end ))) as kredit, 0 as debit, a.dp,
        CONCAT(b.nama,'(',a.potongan,')') as jenis_pembayaran, a.id_jenis_pembayaran as id_pembayaran,
        a.no_invoice as keterangan, a.no_hp, d.tanggal as tgl_dp, a.pelanggan as nama_user, e.nama as nm_cabang
        from transaksi a
        left join ref_jenis_pembayaran b on b.id=a.id_jenis_pembayaran
        left join ref_jenis_pembayaran c on c.id=a.id_jenis_pembayaran_2
        left join dp d on d.kode=a.inv_dp
        left join ref_cabang e on e.id=a.id_cabang
        where a.deleted is null ";

        $penjualan_2 = "SELECT a.id_cabang, a.created as tanggal,'PENJUALAN SPLIT' as jenis_transaksi, (a.total_split - (a.potongan_split+(case when a.id_jenis_pembayaran_2=2 then a.kembalian else 0 end ))) as kredit, 0 as debit, a.dp,
        CONCAT(c.nama,'(',a.potongan_split,')') as jenis_pembayaran, a.id_jenis_pembayaran_2 as id_pembayaran,
        a.no_invoice as keterangan, a.no_hp, d.tanggal as tgl_dp, a.pelanggan as nama_user, e.nama as nm_cabang
        from transaksi a
        left join ref_jenis_pembayaran b on b.id=a.id_jenis_pembayaran
        left join ref_jenis_pembayaran c on c.id=a.id_jenis_pembayaran_2
        left join dp d on d.kode=a.inv_dp
        left join ref_cabang e on e.id=a.id_cabang
        where a.deleted is null and a.is_split='1' ";

        $dp_kredit = "SELECT a.id_cabang, a.tanggal, 'DP' as jenis_transaksi, (a.total-a.total_potongan) as kredit, 0 as debit, 0 as dp, CONCAT(b.nama,'(',a.total_potongan,')') as jenis_pembayaran, a.pembayaran as id_pembayaran,
        CONCAT(a.kode, '<br>', a.keterangan) as keterangan, a.no_hp, '' as tgl_dp, a.nama as nama_user, c.nama as nm_cabang
        from dp a
        left join ref_jenis_pembayaran b on b.id=a.pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        where a.deleted is null";

        $dp_debit = "SELECT a.id_cabang, a.tanggal, 'REFUND DP' as jenis_transaksi, 0 as kredit, a.total as debit, 0 as dp, b.nama as jenis_pembayaran, a.pembayaran as id_pembayaran,
        CONCAT(a.kode, '<br>', a.keterangan) as keterangan, a.no_hp, '' as tgl_dp, a.nama as nama_user, c.nama as nm_cabang
        from dp a
        left join ref_jenis_pembayaran b on b.id=a.pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        where a.deleted is null and a.is_refund='1' ";

        $operasional_debit = "SELECT a.id_cabang, a.tanggal, 'OPERASIONAL' as jenis_transaksi, 0 as kredit, a.jumlah as debit, 0 as dp, b.nama as jenis_pembayaran, a.id_pembayaran as id_pembayaran,
        CONCAT('Jenis :',d.nama,'<br>',a.keterangan) as keterangan, '' as no_hp, '' as tgl_dp, '' as nama_user, c.nama as nm_cabang
        from operasional a
        left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        left join ref_operasional d on d.id=a.id_operasional
        where a.deleted is null";

        $operasional_kredit = "SELECT a.id_cabang, a.tgl_refund as tanggal, 'OPERASIONAL REFUND' as jenis_transaksi, a.jumlah as kredit, 0 as debit, 0 as dp, b.nama as jenis_pembayaran, a.id_pembayaran as id_pembayaran,
        CONCAT('Jenis :',d.nama,'<br>',a.keterangan,' (', a.keterangan_refund ,')') as keterangan, '' as no_hp, '' as tgl_dp, '' as nama_user, c.nama as nm_cabang
        from operasional a
        left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        left join ref_operasional d on d.id=a.id_operasional
        where a.deleted is null and a.is_refund='1' ";

        $kerugian = "SELECT a.id_cabang, a.tanggal, 'KERUGIAN' as jenis_transaksi, 0 as kredit, a.jumlah as debit, 0 as dp, b.nama as jenis_pembayaran, a.id_pembayaran as id_pembayaran,
        CONCAT(a.keterangan) as keterangan, '' as no_hp, '' as tgl_dp, '' as nama_user, c.nama as nm_cabang
        from kerugian a
        left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        where a.deleted is null ";

        $kasbon = "SELECT a.id_cabang, a.tanggal, 'KASBON' as jenis_transaksi, 0 as kredit, a.jumlah as debit, 0 as dp, b.nama as jenis_pembayaran, a.id_pembayaran as id_pembayaran,
        CONCAT(a.keterangan,'<br>Pegawai :',d.nama) as keterangan, '' as no_hp, '' as tgl_dp, '' as nama_user, c.nama as nm_cabang
        from kasbon a
        left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        left join pegawai d on d.id=a.id_pegawai
        where a.deleted is null ";

        $modal_awal = "SELECT a.id_cabang, a.tanggal, 'MODAL AWAL CASH' as jenis_transaksi, a.modal as kredit, 0 as debit, 0 as dp, b.nama as jenis_pembayaran, a.id_pembayaran as id_pembayaran,
        CONCAT('') as keterangan, '' as no_hp, '' as tgl_dp, '' as nama_user, c.nama as nm_cabang
        from modal_awal a
        left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        where a.deleted is null ";

        $servis_kredit_1 = "SELECT a.id_cabang, a.tgl_keluar as tanggal, 'SERVIS IC' as jenis_transaksi, (a.bayar - (a.potongan + (case when a.id_jenis_pembayaran=2 then a.kembalian else 0 end ))) as kredit, 0 as debit, 0 as dp, 
        CONCAT(b.nama,'(',a.potongan,')') as jenis_pembayaran, a.id_jenis_pembayaran as id_pembayaran,
        CONCAT(a.invoice,'<br>Tipe :',a.tipe_unit,'<br>Kerusakan :',a.kerusakan) as keterangan, a.no_hp, '' as tgl_dp, a.pelanggan as nama_user, c.nama as nm_cabang
        from servis_berat a
        left join ref_jenis_pembayaran b on b.id=a.id_jenis_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        left join ref_jenis_pembayaran d on d.id=a.id_jenis_pembayaran_2
        where a.deleted is null and a.tgl_keluar is not null";

        $servis_kredit_2 = "SELECT a.id_cabang, a.tgl_keluar as tanggal, 'SERVIS IC SPLIT' as jenis_transaksi, (a.bayar_split - (a.potongan_split + (case when a.id_jenis_pembayaran_2=2 then a.kembalian else 0 end ))) as kredit, 0 as debit, 0 as dp, 
        CONCAT(d.nama,'(',a.potongan_split,')') as jenis_pembayaran, a.id_jenis_pembayaran_2 as id_pembayaran,
        CONCAT(a.invoice,'<br>Tipe :',a.tipe_unit,'<br>Kerusakan :',a.kerusakan) as keterangan, a.no_hp, '' as tgl_dp, a.pelanggan as nama_user, c.nama as nm_cabang
        from servis_berat a
        left join ref_jenis_pembayaran b on b.id=a.id_jenis_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        left join ref_jenis_pembayaran d on d.id=a.id_jenis_pembayaran_2
        where a.deleted is null and a.tgl_keluar is not null and is_split='1' ";

        $servis_debit = "SELECT a.id_cabang, a.tgl_keluar as tanggal, 'REFUND SERVIS IC' as jenis_transaksi, 0 as kredit, a.biaya as debit, 0 as dp, 
        CONCAT(b.nama) as jenis_pembayaran, a.id_jenis_pembayaran as id_pembayaran,
        CONCAT(a.invoice,'<br>Tipe :',a.tipe_unit,'<br>Kerusakan :',a.kerusakan) as keterangan, a.no_hp, '' as tgl_dp, a.pelanggan as nama_user, c.nama as nm_cabang
        from servis_berat a
        left join ref_jenis_pembayaran b on b.id=a.id_jenis_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        left join ref_jenis_pembayaran d on d.id=a.id_jenis_pembayaran_2
        where a.deleted is null and a.tgl_keluar is not null and a.is_refund='1' ";

        $setor_tunai_debit = "SELECT a.id_cabang, a.tanggal, 'SETOR TUNAI' as jenis_transaksi, 0 as kredit, a.nominal as debit, 0 as dp, 'CASH' as jenis_pembayaran, 2 as id_pembayaran,
        CONCAT('') as keterangan, '' as no_hp, '' as tgl_dp, '' as nama_user, c.nama as nm_cabang
        from setor_tunai a
        left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        where a.deleted is null and a.is_konfirmasi='1' ";

        $setor_tunai_kredit = "SELECT a.id_cabang, a.tanggal, 'SETOR TUNAI' as jenis_transaksi, a.nominal as kredit, 0 as debit, 0 as dp, b.nama as jenis_pembayaran, a.id_pembayaran as id_pembayaran,
        CONCAT('') as keterangan, '' as no_hp, '' as tgl_dp, '' as nama_user, c.nama as nm_cabang
        from setor_tunai a
        left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        where a.deleted is null and a.is_konfirmasi='1' ";

        $refund_penjualan_debit = "SELECT a.id_cabang_asal as id_cabang, a.tanggal, 'REFUND PENJUALAN' as jenis_transaksi, 0 as kredit, b.nilai_refund as debit, 0 as dp, c.nama as jenis_pembayaran, b.pembayaran as id_pembayaran,
        CONCAT(e.no_invoice) as keterangan, e.no_hp as no_hp, '' as tgl_dp, e.pelanggan as nama_user, d.nama as nm_cabang
        from refund a
        left join refund_detail b on b.id_refund=a.id and b.deleted is null and b.id_klaim in (3,4)
        left join ref_jenis_pembayaran c on c.id=b.pembayaran
        left join ref_cabang d on d.id=a.id_cabang_asal
        left join transaksi e on e.id=a.id_transaksi
        where a.deleted is null ";

        $query = "($penjualan_1) UNION ALL ($penjualan_2) UNION ALL ($dp_kredit) UNION ALL ($dp_debit) UNION ALL ($operasional_debit) 
        UNION ALL ($operasional_kredit) UNION ALL ($kerugian) UNION ALL ($kasbon) UNION ALL ($modal_awal)
        UNION ALL ($servis_kredit_1) UNION ALL ($servis_kredit_2) UNION ALL ($servis_debit) UNION ALL ($setor_tunai_debit) UNION ALL ($setor_tunai_kredit)
        UNION ALL ($refund_penjualan_debit)";

        return $query;
    }
}
