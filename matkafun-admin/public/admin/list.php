<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start($this->router->fetch_class(), 'add/user', 'add_admin'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">

			<div class="table-responsive mb-4 mt-4">
				<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
					<thead>
						<tr>
							<th style="width: 1%">#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Status</th>
							<th>Created date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($userData)) :
							$i = 1;
							foreach ($userData as $key => $value) : ?>
								<tr>
									<td><?php echo $i++; ?>.</td>
									<td>
										<span class="pr-3 py-0 d-block position-relative">
											<span>
												<p class="admin-name mb-0">
													<?php echo ucwords("$value->username"); ?>
												</p>
											</span>
											<!-- <span class="badge counter">
												<div class="t-dot bg-primary" data-toggle="tooltip" data-placement="top" title="Pinned" data-original-title="Pinned"></div>
											</span> -->
										</span>
										<p class="mb-0 mt-2">
											<a href="tel://+91<?php echo $value->mobile; ?>">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-call text-success br-6 mb-1 p-1">
													<path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
												</svg>
												+91 <?php echo $value->mobile; ?>
											</a>
										</p>
									</td>
									<td><?php echo $value->email; ?></td>
									<td>
										<span class="badge px-2 py-1 outline-badge-warning">
											<?php echo strtoupper($value->group_title); ?>
										</span>
									</td>
									<td>
										<?php $value->status === '1' and $status = ' Active ' and $class = 'success'; ?>
										<span class="badge px-2 py-1 badge-<?php echo $class; ?>">
											<?php echo $status; ?>
										</span>
									</td>
									<td>
										<?php if (is_numeric($value->created_date)) : ?>
											<?php echo date('M d, Y', $value->created_date),
												' At<br>',
												date('h: i A', $value->created_date); ?>
										<?php else : ?>
											<?php echo date('M d, Y', strtotime($value->created_date)),
												' At<br>',
												date('h: i A', strtotime($value->created_date)); ?>
										<?php endif; ?>
									</td>
									<td>
										<ul class="table-controls">

											<li>
												<a href="mailto://<?php echo $value->email; ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $value->email; ?>">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail p-1 br-6 mb-1">
														<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
														<polyline points="22,6 12,13 2,6" />
													</svg>
												</a>
											</li>

											<li>
												<a href="<?php echo SITE_URL . 'edit/admin/' . $value->id; ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
														<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
														</path>
													</svg>
												</a>
											</li>

											<?php if (user_can('admin_delete')) : ?>
												<li>
													<a class="deleteConfirm" data-delete-url="<?php echo SITE_URL . 'delete/admin/' . $value->id; ?>">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1">
															<polyline points="3 6 5 6 21 6"></polyline>
															<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
															</path>
														</svg>
													</a>
												</li>
											<?php endif; ?>
										</ul>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Status</th>
							<th>Created date</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>