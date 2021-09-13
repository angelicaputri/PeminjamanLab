	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Peminjaman Laboratorium
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-archive"></i> &nbsp; Peminjaman Laboratorium</li>
				<li class="active">Tambah Data</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Insert New Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Data
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body show" id="add_new">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo $message;?>
						<form id="input_form" action="<?php echo base_url('inventory/add') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
								<h3>Info Peminjaman</h3>
								<fieldset>
									<div class="form-group">
										<label for="code" class="control-label col-md-2">Kode Peminjaman Laboratorium</label>
										<div class="col-md-8">
											<input type="text" name="code" id="code" class="form-control" value="<?= $kodeunik;  ?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="brand" class="control-label col-md-2">Nama Peminjam</label>
										<div class="col-md-8">
											<input type="text" name="brand" id="brand" class="form-control <?php echo set_value('brand');?>" value="<?php echo set_value('brand') ?>" required>
											<div class="autocomplete-suggestions hide">
										    <div class="autocomplete-suggestion autocomplete-selected"></div>
										    <div class="autocomplete-suggestion"></div>
										    <div class="autocomplete-suggestion"></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="description" class="control-label col-md-2">Tujuan Peminjaman</label>
										<div class="col-md-8">
											<textarea name="description" id="description" class="form-control <?php echo set_value('description');?>" rows="4" style="resize:vertical; min-height:100px; max-height:200px;" value="<?php echo set_value('description') ?>" required></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="serial_number" class="control-label col-md-2">No. HP Peminjam</label>
										<div class="col-md-2">
											<input type="text" name="serial_number" id="serial_number" class="form-control <?php echo set_value('serial_number');?>" value="<?php echo set_value('serial_number') ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label for="hari" class="control-label col-md-2">Hari</label>
										<div class="col-md-2">
											<select name="hari" id="hari" class="form-control <?php echo set_value('hari');?>" value="<?php echo set_value('hari') ?>" required style="width:100%">
												  <option value="Senin">Senin</option>
												  <option value="Selasa">Selasa</option>
												  <option value="Rabu">Rabu</option>
												  <option value="Kamis">Kamis</option>
												  <option value="Jumat">Jumat</option>
												  <option value="Sabtu">Sabtu</option>
												  <option value="Minggu">Minggu</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="tanggal" class="control-label col-md-2">Tanggal</label>
										<div class="col-md-2">
											<input type="text" name="tanggal" id="tanggal" class="tanggal form-control <?php echo set_value('tanggal');?>" value="<?php echo set_value('tanggal') ?>" required>
										</div>
										<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
											<script>
												$(document).ready(function() {
													$(".tanggal").datepicker({
														weekStart:1,
														autoclose:true,
														format:'yyyy-mm-dd',
														todayHighlight:true,
														todayBtn:'linked',
													});
												});
											</script>
									</div>
									<div class="form-group">
										<label for="mulai" class="control-label col-md-2">Jam Mulai</label>
										<div class="col-md-2">
											<input type="time" name="mulai" id="mulai" class="form-control <?php echo set_value('mulai');?>" value="<?php echo set_value('mulai') ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label for="model" class="control-label col-md-2">Jam Selesai</label>
										<div class="col-md-2">
											<input type="time" name="model" id="model" class="form-control <?php echo set_value('model');?>" value="<?php echo set_value('model') ?>" required>
										</div>
									</div>
									
									<div class="form-group">
										<label for="location" class="control-label col-md-2"> Location</label>
										<div class="col-md-4">
											<select name="location" id="location"  class="form-control <?php echo set_value('location');?>" value="<?php echo set_value('location') ?>" style="width:100%" required >
												<?php foreach ($loc_list->result() as $lls) {
													echo "<option value='".$lls->id."'>".$lls->name."</option>";
													} ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="keterangan" class="control-label col-md-2">Keterangan</label>
										<div class="col-md-2">
											<input type="text" name="keterangan" id="keterangan" class="form-control <?php echo set_value('keterangan');?>" value="<?php echo set_value('keterangan') ?>" required>
										</div>
									</div>
								</fieldset>
						</form>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
