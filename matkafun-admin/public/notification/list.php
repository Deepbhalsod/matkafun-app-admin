<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('Notifications', 'add/notification', 'add_notification');

?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">

			<div class="table-responsive mb-4 mt-4">

				<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
					<thead>
						<tr class="text-center">
							<th>#</th>
							<th>Username</th>
							<th>Title</th>
							<th>Content</th>
							<th>Created Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1;
						if (is($NotificationData, 'json') and is($NotificationData->data, 'array')) :

							foreach ($NotificationData->data as $key => $value) : ?>
								<tr class="text-center">
									<td><?php echo $i++; ?>.</td>
									
									    <td>
                                            <?php if (empty($value->user_id)) {
                                                echo "N/A";
                                            } elseif($value->user_id=="all"){
                                                echo "All";
                                            }else {
                                                $returnss = get_signle_data_from('users', ['id' => $value->user_id]);
                                                echo $return1ww = $returnss->username;
                                                if ($return1ww) {
                                                    echo ($return1ww);
                                                } else {
                                                    echo "N/A";
                                                }
                                            } ?>
                                        </td>


									<td>
										<span class="pr-3 py-0 <?php $i == 1 or print('mt-3'); ?>  d-block position-relative">
											<span>
												<p class="admin-name mb-0">
													<?php is($value->heading, 'showCapital'); ?>
												</p>
											</span>
										</span>

									</td>
									<td>
										<span class="pr-3 py-0 <?php $i == 1 or print('mt-3'); ?>  d-block position-relative">
											<span>
												<p class="admin-name mb-0">
													<?php is($value->message, 'show'); ?>
												</p>
											</span>
										</span>

									</td>

									<!-- <td class="">
										<span class="badge px-2 py-1 badge-<?php is(get_status($value->status)->class, 'show'); ?>">
											<?php is(get_status($value->status)->title, 'show'); ?>
										</span><br><br>
									</td>

									<td class="">
										<div class="field-wrapper">
											<input type="hidden" name="notii_id" id="notii_id" value="<?= $value->id; ?>" />
											<button type="submit" class="btn badge px-2 py-1 badge btn-outline-primary" value="1" name="chng_status" formaction="<?= SITE_URL; ?>Notification/change_status_notification/<?= $value->id; ?>">Active</button>
											<button type="submit" class="btn badge px-2 py-1 badge btn-outline-danger" value="2" name="chngstatus" formaction="<?= SITE_URL; ?>Notification/change_status_notification/<?= $value->id; ?>">Inactive</button>
										</div>
									</td> -->

									<td>
										<?php is($value->created_date, 'datetime'); ?>
									</td>

									<td>
										<ul class="table-controls">
											<!-- <li>
												<a href="<?php echo SITE_URL . 'edit/notification/' . $value->id;  ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
														<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
														</path>
													</svg>
												</a>
											</li> -->
											<?php if (user_can('notification_delete')) : ?>
												<li>
													<a class="deleteConfirm" data-delete-url="<?php echo SITE_URL . 'delete/notification/' . $value->id; ?>">
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
		</div>
	</div>
</div>