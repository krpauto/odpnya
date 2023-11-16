<?php if (!defined('BASEPATH')) exit('No direct script acess allowed'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit" style="color:green"> </i> Daftar Data Odp
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
            <li class="active"><i class="fa fa-file-text"></i>&nbsp; Daftar Data Odp</li>
        </ol>
    </section>
    <section class="content">
        <?php if (!empty($this->session->flashdata())) {
            echo $this->session->flashdata('pesan');
        } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <?php if ($this->session->userdata('level') == 'Admin PTI') { ?>
                            <a href="odp/tambah"><button class="btn btn-primary"><i class="fa fa-plus"> </i> Tambah Odp</button></a>
                        <?php } ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">

                            <br />
                            <table id="example1" class="table table-bordered table-striped table" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Odp</th>
                                        <th>Status </th>
                                        <th>Alamat</th>
                                        <th>Foto</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <?php if ($this->session->userdata('level') == 'Admin PTI') { ?>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($odp as $o) { ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $o['nama_odp']; ?></td>
                                                <td><?= $o['status']; ?></td>
                                                <td><?= $o['alamat']; ?></td>
                                                <td> <img src="<?= base_url(); ?>assets_style/file/<?php echo $o['foto']; ?>" class="img-responsive" style="height:auto;width:100px;" /></td>>
                                                <td><?= $o['longitude']; ?></td>
                                                <td><?= $o['latitude']; ?></td>
                                                <td style="width:17%;">
                                                    <a href="<?= base_url('odp/edit/' . $o['id_odp']); ?>"><button class="btn btn-success"><i class="fa fa-edit"></i></button></a>
                                                    <a href="<?= base_url('odp/detail/' . $o['id_odp']); ?>"><button class="btn btn-primary"><i class="fa fa-sign-in"></i> Detail</button></a>
                                                    <button data-toggle="modal" data-target="#del<?= $o['id_odp'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php $no++;
                                        } ?>
                                    </tbody>

                                    </tr>
                                <?php $no++;
                                } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Hapus -->
<?php foreach ($odp as $us) : ?>
    <div class="modal fade" id="del<?= $us['id_odp'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"><b>Hapus Unit</b></h4>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus Odp <strong><?= $us['nama_odp'] ?></strong> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <a class="btn btn-danger" href="<?= base_url('odp/del/' . $us['no_odp']); ?>">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>