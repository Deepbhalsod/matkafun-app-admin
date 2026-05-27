<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start($settingData->type, 'add/setting', 'setting_add');
// print_r($settingData);
?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">

			<div class="table-responsive mb-4 mt-4">
				<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
					<thead>
						<tr>
							<th>#</th>
							<th class="text-center" style="width: 30%">Setting Name</th>
							<th class="text-left" style="width: 40%">Setting Value</th>
							<?php if (user_can('setting_edit')) : ?>
								<th>Action</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php $i = 1;
						if (is($settingData, 'json') and is($settingData->data, 'array')) :
							foreach ($settingData->data as $value) : ?>
								<?php if (is($type) and (in_array($value->option_key, SETTINGS[$type]) or ($type === 'social-media' and strpos($value->option_key, 'social') !== false))) : ?>
									<tr>
										<td><?php echo $i++; ?>.</td>
										<td class="text-center">
											<p class="align-self-center mb-0 admin-name">
												<?php is($value->option_key) and print(ucwords(str_replace('_', ' ', str_replace('social_', '', str_replace('site_', '', $value->option_key))))); ?>
											</p>
										</td>

										<td class="text-left">
											<div class="mr-2 mx-auto rounded-lg">
												<?php if (is($value->option_value)) : ?>
													<?php if (search_in($value->option_value, ['.jpg', '.png', '.jpeg'])) : ?>
														<div style="width: 150px;">
															<img src="<?php is($value->option_value, 'show'); ?>" class="img-fluid shadow rounded-lg" alt="<?php is($value->key, 'show'); ?>">
														</div>
													<?php elseif (search_in($value->option_value, 'https://maps.google.com')) : ?>
														<iframe width="100%" height="150" id="gmap_canvas" src="<?php is($value->option_value, 'show'); ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
													<?php elseif (search_in($value->option_value, ['https://', 'http://'])) : ?>
														<div class="linkPreview">
															<a href="<?php is($value->option_value, 'show'); ?>"><?php is($value->option_value, 'show'); ?></a>
														</div>
													<?php elseif (search_in($value->option_key, ['web_logo','admin_favicon','web_favicon','banner_img_1','banner_img_2','banner_img_3','admin_logo','
    					web_favicon'])) :
    					     $img_bnr = ($value->option_value);
                //                                     $decoded = decodeBase64Image($img_bnr, 'setting/');
												    // $logo =SITE_URL."uploads/setting/".$decoded;
    					                                  ?>
														<div style="width: 150px;">
															<img src="<?php echo($img_bnr); ?>" class="img-fluid shadow rounded-lg" alt="<?php is($value->key, 'show'); ?>">
														</div>
													<?php else : ?>
														<?php is($value->option_value, 'show'); ?>
													<?php endif; ?>
												<?php endif; ?>
											</div>
										</td>
										<?php if (user_can('setting_edit')) : ?>
											<td class="text-left">
												<ul class="table-controls">
													<li>
														<a href="<?php echo SITE_URL . 'edit/setting/' . $value->option_key; ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
																<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
																</path>
															</svg>
														</a>
													</li>
												</ul>
											</td>
										<?php endif; ?>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>

				</table>
			</div>