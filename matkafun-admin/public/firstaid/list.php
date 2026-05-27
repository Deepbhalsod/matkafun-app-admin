<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('app_image', 'add/app_image', 'app_image_add'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">

			<div class="table-responsive mb-4 mt-4">
				<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
					<thead>
						<tr class="text-center">
							<th style="width: 2%">#</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php $i = 1;
						if (!empty($banner)) :

							foreach ($banner as $key => $value) :
						?>
								<tr>
									<td><?php echo $i++; ?>.</td>



									<td class="text-center">
										<?php if (!empty($value['image'])) : ?>
											<img src="<?php echo $value['image']; ?>" class="img-fluid shadow rounded-lg" style="border: 2px solid #d3d3d3; height: 80px; width:80px " alt="">
										<?php else : ?>
											<p>image Not Found</p>
										<?php endif; ?>
									</td>


									<td class="text-center">
										<ul class="table-controls">


											<li>
												<a class="deleteConfirm" data-delete-url="<?php echo SITE_URL . 'delete/firstaid/' . $value['id']; ?>">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1">
														<polyline points="3 6 5 6 21 6"></polyline>
														<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
														</path>
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