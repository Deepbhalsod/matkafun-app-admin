<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">

			<div class="table-responsive my-4">
				<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
					<thead>
						<tr>
							<th style="width: 1%">#</th>
							<th>UserName</th>
							<th>Mobile Number</th>
							<th>Query</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($userData)) :
							$i = 1;
							foreach ($userData as $key => $value) : ?>

								<tr>
									<td><?php echo $i++; ?>.</td>
									<td><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>">
										<?php if (empty($value['user_id'])) {
											echo "N/A";
										} else {
											$returnss = get_signle_data_from('users', ['id' => $value['user_id']]);
										
											if ($returnss) {
											    $return1ww = $returnss->username;
												echo ($return1ww);
											} else {
												echo "N/A";
											}
										} ?>

									</a></td>


									<td><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>">
										<?php echo $value['mobile']; ?>
									</a></td>

									<td>
										<?php echo $value['query']; ?>
									</td>

									<td>
										<?php echo $value['date']; ?>
									</td>


								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>