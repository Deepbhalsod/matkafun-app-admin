<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">

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
						<?php if (!empty($userData)) :
							$i = 1;
							foreach ($userData as $key => $value) : ?>

								<tr>
									<td><?php echo $i++; ?>.</td>
									<td>
										<p><?php echo $value->username; ?></p>

									</td>


									<td>
										<?php echo $value->mobile; ?>
									</td>

									<td>
										<?php if (is_numeric($value->registred_date)) : ?>
											<?php echo date('M d, Y', $value->registred_date),
											' At<br>',
											date('h: i A', $value->registred_date); ?>
										<?php else : ?>
											<?php echo date('M d, Y', strtotime($value->registred_date)),
											'  ',
											date('h: i A', strtotime($value->registred_date)); ?>
										<?php endif; ?>
									</td>

									<td>
										<?php echo $value->balance; ?>
									</td>

									<td>
										<span class="badge outline-badge-danger">No</span>

									</td>

									<td>
										<span class="badge px-2 py-1 badge-<?php is(get_status($value->status)->class, 'show'); ?>">
											<?php is(get_status($value->status)->title, 'show'); ?>
										</span>

										<div class="btn-group" id="btns<?php echo $i ?>">
											<div class="btn-group">
												<button type="button" class="badge px-2 py-1 badge dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Edit<span class="caret"></span></button>
												<ul class="dropdown-menu" role="menu">

													<?php if ($value->status == 1) { ?>
														<li><a href="<?= SITE_URL; ?>User/change_status_user/<?= $value->id; ?>/inactive">Inactive</a></li>
													<?php } else { ?>
														<li><a href="<?= SITE_URL; ?>User/change_status_user/<?= $value->id; ?>/active">Active</a></li>
													<?php        }   ?>
												</ul>
											</div>
										</div>
									</td>
									<td>
										<ul class="table-controls">
											<li>
												<a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value->id;  ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye p-1 br-6 mb-1">
														<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
														<circle cx="12" cy="12" r="3" />
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