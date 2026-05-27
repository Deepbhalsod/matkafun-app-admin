<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('slider', 'add/slider', 'slider_add'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">
			<form method="post">
				<div class="table-responsive mb-4 mt-4">
					<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
						<thead>
							<tr class="text-center">
								<th style="width: 2%">#</th>
								<th>Image</th>
								<th>Title</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody class="text-center">
							<?php $i = 1;
							if (!empty($sliderData) and !empty($sliderData->data)) :

								foreach ($sliderData->data as $key => $value) :
							?>
									<tr>
										<td><?php echo $i++; ?>.</td>

										<td>
											<div class="mr-2 mx-auto w-50 rounded-lg">
												<?php if (!empty($value->image)) : 
												    $img_bnr = ($value->image);
                                                       //      $decoded = decodeBase64Image($img_bnr, 'slider/');
												    // $logo =SITE_URL."uploads/slider/".$decoded;
												?>
													<img src="<?php echo $img_bnr; ?>" class="img-fluid shadow rounded-lg" style="border: 2px solid #d3d3d3; height: 80px; width:80px " alt="">
												<?php else : ?>
													<p>Image Not Found</p>
												<?php endif; ?>
											</div>
										</td>

										<td class="text-center">
											<p class="align-self-center mb-0 admin-name">
												<?php echo ucwords($value->title); ?>
											</p>
										</td>

										<td class="" id="showsliderstatus">
											<span class="badge px-2 py-1 badge-<?php is(get_status($value->status)->class, 'show'); ?>">
												<?php is(get_status($value->status)->title, 'show'); ?>
											</span>

											<div class="btn-group" id="btns<?php echo $i ?>">
												<div class="btn-group">
													<button type="button" class="badge px-2 py-1 badge dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Edit<span class="caret"></span></button>
													<ul class="dropdown-menu" role="menu">

														<?php if ($value->status == 1) { ?>
															<li><a href="<?= SITE_URL; ?>Slider/change_status/<?= $value->id; ?>/inactive">Inactive</a></li>
														<?php } else { ?>
															<li><a href="<?= SITE_URL; ?>Slider/change_status/<?= $value->id; ?>/active">Active</a></li>
														<?php        }   ?>
													</ul>
												</div>
											</div>
										</td>

										<td class="text-center">
											<ul class="table-controls">
												<li>
													<a href="<?php echo SITE_URL . 'edit/slider/' . $value->id;  ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
															<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
															</path>
														</svg>
													</a>
												</li>
												<?php if (user_can('slider_delete')) : ?>
													<li>
														<a class="deleteConfirm" data-delete-url="<?php echo SITE_URL . 'delete/slider/' . $value->id; ?>">
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
					</table>
				</div>
			</form>
		</div>
	</div>
</div>