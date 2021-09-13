	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Data Peminjaman
				<small>All your items data</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url("inventory") ?>"><i class="fa fa-archive"></i> Data Peminjaman</a></li>
				<li class="active">All Data</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Data Peminjaman
					</h3>
					<div class="box-tools pull-right">
						<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>
					<div class="table-responsive">
						<table class="table table-hover table-bordered table-striped" id="myTable">
							<thead>
								<tr>
									<th width="5%">Kode Peminjaman</th>
									<th>Nama Peminjam </th>
									<th >Tujuan Peminjaman</th>
									<th>Hari</th>
									<th>Tanggal</th>
									<th>Jam Pelaksanaan</th>
									<th>Laboratorium</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody>
							<?php if (count($data_list->result())>0): ?>
								<?php foreach ($data_list->result() as $data): ?>
								<tr>
									<td><?php echo $data->code; ?></td>
									<td><?php echo $data->brand; ?></td>
									<td><?php echo $data->description; ?></td>
									<td><?php echo $data->hari; ?></td>
									<td><?php echo $data->tanggal; ?></td>
									<td><?php echo $data->mulai . " - " . $data->model; ?></td>
									<!-- <td><?php echo $data->model; ?></td> -->
									<td><?php echo $data->location_name; ?></td>
									<td><?php echo $data->keterangan;?></td>
								</tr>
								<?php endforeach ?>
							<?php else: ?>
								<tr>
									<td class="text-center" colspan="8">No Data Found!</td>
								</tr>
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<?php echo $pagination; ?>
					<?php echo (isset($last_query)) ? $last_query : ""; ?>&nbsp;
					<!-- Footer -->
				</div>
				<!-- /.box-footer-->
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
