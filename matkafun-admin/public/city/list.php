<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php breadcrumb_start('city', 'add/city', 'city_add');
?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">
			<form method="post">
				<div class="table-responsive mb-4 mt-4">
					<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
						<thead>
							<tr class="">
								<th>#</th>
								<th>Icon</th>
								<th>Name</th>
								<th>Name in tamil</th>
								<th>Name in hindi</th>
								<th>Status</th>
								<th>Action</th>

							</tr>
						</thead>
						<tbody>
							<?php $i = 1;
							if (is($categoryData, 'json') and is($categoryData->data, 'array')) :

								foreach ($categoryData->data as $key => $value) : ?>
									<tr>
										<td><?php echo $i++; ?>.</td>
										<td>
											<div class="rounded-lg">
												<?php if (is($value->icon)) : ?>
													<img src="<?php is($value->icon, 'show'); ?>" class="img-fluid shadow rounded-lg" style="border: 2px solid #d3d3d3; width:80px; height:80px;" alt="">
												<?php endif; ?>
											</div>
										</td>
										<td class="">
											<p class="align-self-center mb-0 admin-name">
												<?php is($value->city, 'showCapital'); ?>
											</p>
										</td>

										<td class="">
											<p class="align-self-center mb-0 ">
												<?php echo ($value->city_tamil); ?>
											</p>
										</td>

										<td class="">
											<p class="align-self-center mb-0 ">
												<?php echo ($value->city_hindi); ?>
											</p>
										</td>


										<td class="">
											<span class="badge px-2 py-1 badge-<?php is(get_status($value->status)->class, 'show'); ?>">
												<?php is(get_status($value->status)->title, 'show'); ?>
											</span>

											<div class="btn-group" id="btns<?php echo $i ?>">
												<div class="btn-group">
													<button type="button" class="badge px-2 py-1 badge dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Edit<span class="caret"></span></button>
													<ul class="dropdown-menu" role="menu">

														<?php if ($value->status == 1) { ?>
															<li><a href="<?= SITE_URL; ?>City/change_status_city/<?= $value->id; ?>/inactive">Inactive</a></li>
														<?php } else { ?>
															<li><a href="<?= SITE_URL; ?>City/change_status_city/<?= $value->id; ?>/active">Active</a></li>
														<?php        }   ?>
													</ul>
												</div>
											</div>
										</td>

										<?php if (user_can('city_edit') or user_can('city_delete')) : ?>
											<td class="">
												<ul class="table-controls">
													<?php if (user_can('city_edit')) : ?>
														<li>
															<a href="<?php echo SITE_URL . 'edit/city/' . $value->id; ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
																	<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
																	</path>
																</svg>
															</a>
														</li>
													<?php endif; ?>
													<?php if (user_can('city_delete')) : ?>
														<li>
															<a class="deleteConfirm bs-tooltip" data-delete-url="<?php echo SITE_URL . 'delete/city/' . $value->id; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>