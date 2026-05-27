<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="/other.css">

<div class="row">
	<div class="">
		<div class="userList">
			<div class="table-responsive my-4">
				<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
					<thead>
						<tr>
							<th style="width: 1%">#</th>
							<th>Name</th>
							<th>Mobile Number</th>
							<th>Date</th>
							<th>Balance</th>
							<th>Transfer</th>
							<th>Active</th>
							<th>View</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($userData)):
							$i = 1;
							foreach ($userData as $key => $value): ?>
								<tr>
									<td>
										<?php echo $i++; ?>.
									</td>
									<td><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value->id; ?>">
											<p>
												<?php echo $value->username; ?>
											</p>
										</a></td>
									<td><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value->id; ?>"><?php echo $value->mobile; ?></a>
										<a href="https://wa.me/91<?php echo $value->mobile; ?>" target="_blank"><svg
												xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="25px"
												height="25px">
												<path fill="#fff"
													d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z" />
												<path fill="#fff"
													d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z" />
												<path fill="#cfd8dc"
													d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z" />
												<path fill="#40c351"
													d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z" />
												<path fill="#fff" fill-rule="evenodd"
													d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z"
													clip-rule="evenodd" />
											</svg></span>
									</td>
									<td>
										<?php if (is_numeric($value->registred_date)): ?>
											<?php echo date('M d, Y', $value->registred_date),
												' At<br>',
												date('h: i A', $value->registred_date); ?>
										<?php else: ?>
											<?php echo date('M d, Y', strtotime($value->registred_date)),
												'  ',
												date('h: i A', strtotime($value->registred_date)); ?>
										<?php endif; ?>
									</td>
									<td>
										<?php echo $value->available_points; ?>
									</td>
									<td>
										<?php if ($value->transfer == 1) { ?>
											<a href="<?= SITE_URL; ?>User/trans_status_user/<?= $value->id; ?>"><span
													class="badge px-2 py-1 badge-success">Yes</span></a>
										<?php } else { ?>
											<a href="<?= SITE_URL; ?>User/trans_status_user/<?= $value->id; ?>"><span
													class="badge px-2 py-1 badge-danger">No</span></a>
										<?php } ?>
									</td>

									<td>
										<?php if ($value->status == 1) { ?>
											<a href="<?= SITE_URL; ?>User/change_status_user/<?= $value->id; ?>/inactive"><span
													class="badge px-2 py-1 badge-success">Active</span></a>
										<?php } else if ($value->status == 2) { ?>
												<a href="<?= SITE_URL; ?>User/change_status_user/<?= $value->id; ?>/active"><span
														class="badge px-2 py-1 badge-danger">Inactive</span></a>
										<?php } ?>
									</td>
									<td>
										<ul class="table-controls">
											<li>
												<a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value->id; ?>"
													class="bs-tooltip" data-toggle="tooltip" data-placement="top" title=""
													data-original-title="View">
													<svg xmlns="http://www.w3.org/2000/svg " width="24" height="24"
														viewBox="0 0 24 24" fill="none"
														class="feather feather-eye p-1 br-6 mb-1">
														<path opacity="0.5"
															d="M2.27489 12.2957C1.42496 11.1915 1 10.6394 1 9C1 7.36062 1.42496 6.80853 2.27489 5.70433C3.97196 3.49956 6.81811 1 11 1C15.1819 1 18.028 3.49956 19.7251 5.70433C20.575 6.80853 21 7.36062 21 9C21 10.6394 20.575 11.1915 19.7251 12.2957C18.028 14.5004 15.1819 17 11 17C6.81811 17 3.97196 14.5004 2.27489 12.2957Z"
															stroke="#1C274C" stroke-width="1.5" />
														<path
															d="M14 9C14 10.6569 12.6569 12 11 12C9.34315 12 8 10.6569 8 9C8 7.34315 9.34315 6 11 6C12.6569 6 14 7.34315 14 9Z"
															stroke="#1C274C" stroke-width="1.5" />
													</svg>
												</a>
											</li>
										</ul>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
			
			<script>
			    $('#multi-column-ordering').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "<?= SITE_URL ?>User/user_list_ajax",
        type: "POST"
    },
    pageLength: 10
});
			</script>