<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php breadcrumb_start('Category', 'add/category', 'category_add');
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
								<th>Image</th>
								<th>Title</th>
								<th>Title in tamil</th>
								<th>Title in hindi</th>
								<th>Descriptions</th>
								<th>Status</th>
								<?php if (user_can('category_edit') or user_can('category_delete')) : ?>
									<th>Action</th>
								<?php endif; ?>
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
												<?php if (is($value->image)) : ?>
													<img src="<?php is($value->image, 'show'); ?>" class="img-fluid shadow rounded-lg" style="border: 2px solid #d3d3d3; width:80px; height:80px;" alt="<?php is($value->title, 'show'); ?>">
												<?php endif; ?>
											</div>
										</td>
										<td class="">
											<p class="align-self-center mb-0 admin-name">
												<?php is($value->title, 'showCapital'); ?>
											</p>
										</td>

										<td class="">
											<p class="align-self-center mb-0 admin-name">
												<?php is($value->tamil_title, 'showCapital'); ?>
											</p>
										</td>

										<td class="">
											<p class="align-self-center mb-0 admin-name">
												<?php is($value->hindi_title, 'showCapital'); ?>
											</p>
										</td>

										<td>
											<p><a href="<?= SITE_URL; ?>Category/list_details/<?= $value->id; ?>"><b>View</b></a></p>
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
															<li><a href="<?= SITE_URL; ?>Category/change_status/<?= $value->id; ?>/inactive">Inactive</a></li>
														<?php } else { ?>
															<li><a href="<?= SITE_URL; ?>Category/change_status/<?= $value->id; ?>/active">Active</a></li>
														<?php        }   ?>
													</ul>
												</div>
											</div>
										</td>


										<?php if (user_can('category_edit') or user_can('category_delete')) : ?>
											<td class="">
												<ul class="table-controls">
													<?php if (user_can('category_edit')) : ?>
														<li>
															<a href="<?php echo SITE_URL . 'edit/category/' . $value->id; ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
																	<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
																	</path>
																</svg>
															</a>
														</li>
													<?php endif; ?>
													<?php if (user_can('category_delete')) : ?>
														<li>
															<a class="deleteConfirm bs-tooltip" data-delete-url="<?php echo SITE_URL . 'delete/category/' . $value->id; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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