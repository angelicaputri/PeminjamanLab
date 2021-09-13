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
					<a href="<?php echo base_url("inventory/createXLS") ?>" target="blank" class="btn btn-sm btn-primary"> <i class="fa fa-file-excel-o"></i></a>
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
									<th>Tujuan Peminjaman</th>
									<th width="5%">No. HP Peminjam</th>
									<th>Hari</th>
									<th>Tanggal</th>
									<th>Jam Pelaksanaan</th>
									<th>Laboratorium</th>
									<th>Keterangan</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<?php if (count($data_list->result())>0): ?>
									<?php foreach ($data_list->result() as $data): ?>
										<tr>
											<td><?php echo $data->code; ?></td>
											<td><?php echo $data->brand; ?></td>
											<td><?php echo $data->description; ?></td>
											<td><?php echo $data->serial_number; ?></td>
											<td><?php echo $data->hari; ?></td>
											<td><?php echo $data->tanggal; ?></td>
											<td><?php echo $data->mulai . " - " . $data->model; ?></td>
											<td><?php echo $data->location_name; ?></td>
											<td><?php echo $data->keterangan;?></td>
											<td width="5%">
												<form action="<?php echo base_url('inventory/delete/'.$data->code) ?>" method="post" autocomplete="off">
													<div class="btn-group-vertical">
														<a class="btn btn-sm btn-primary" href="<?php echo base_url('inventory/edit/'.$data->code) ?>" role="button"><i class="fa fa-pencil"></i></a>
														<input type="hidden" name="id" value="<?php echo $data->id; ?>">
														<button type="submit" class="btn btn-sm btn-danger" role="button" onclick="return confirm('Delete this data?')"><i class="fa fa-trash"></i> </button>
													</div>
												</form>
											</td>
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
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!-- =========================== / CONTENT =========================== -->

