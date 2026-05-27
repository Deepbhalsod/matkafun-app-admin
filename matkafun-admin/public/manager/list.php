<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">

			<div class="table-responsive mb-4 mt-4">
				<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
					<thead>
						<tr class="text-center">
							<th style="width: 2%">#</th>
							<th>Download</th>
							<th>Url</th>
							<th>Created Date</th>
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
										<a href="<?php echo $value['url'] ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Apk" target="_blank" download="download">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud">
												<polyline points="8 17 12 21 16 17"></polyline>
												<line x1="12" y1="12" x2="12" y2="21"></line>
												<path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
											</svg>
									</td>

									<td class="text-center" style="width:1px;">
										<p class="admin-name mb-0">
											<?php echo ($value['url']); ?>
										</p>
									</td>



									<td class="text-center">
										<p class="align-self-center mb-0 admin-name">
											<?php echo ucwords($value['created_date']); ?>
										</p>
									</td>


									<td class="text-center">
										<ul class="table-controls">
											<li>
												<a href="<?php echo SITE_URL . 'add/manager/' ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
														<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
														</path>
													</svg>
												</a>
											</li>
											<!--  -->

										</ul>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>

				</table>
			</div>