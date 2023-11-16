<?php if (!defined('BASEPATH')) exit('No direct script acess allowed'); ?>
<link href="<?= base_url() ?>assets_style/leaflet/leaflet.css" rel="stylesheet">
<script src="<?= base_url() ?>assets_style/leaflet/leaflet.js"></script>

<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<i class="fa fa-list" style="color:green"> </i> <?= $title_web; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-list"></i>&nbsp; <?= $title_web; ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-primary">
					<div class="box-center">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h4>Detail Unit <?= $unit->nama_unit; ?></h4>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table class="table table-striped table-bordered">
							<tr>
								<td>Nama Unit</td>
								<td>:</td>
								<td><?= $unit->nama_unit; ?></td>
							</tr>
							<tr>
								<td>Kepala Unit</td>
								<td>:</td>
								<td><?= $unit->nama_kepala_unit; ?></td>
							</tr>
							<tr>
								<td>Luas Tanaman Menghasilkan</td>
								<td>:</td>
								<td><?= $unit->luas_tm; ?></td>
							</tr>
							<tr>
								<td>Luas Tanaman Belum Menghasilkan</td>
								<td>:</td>
								<td><?= $unit->luas_tbm; ?></td>
							</tr>
							<tr>
								<td>Luas Total Unit</td>
								<td>:</td>
								<td><?= $unit->luas; ?></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>:</td>
								<td><?= $unit->alamat; ?></td>
							</tr>
							<tr>
								<td>Gambar</td>
								<td>:</td>
								<td> <img src="<?= base_url(); ?>assets_style/file/<?php echo $unit->foto; ?>" class="img-responsive" style="height:auto;width:250px;" /></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>