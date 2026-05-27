<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 2%">#</th>
                                <th>Username</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $i = 1;
                            if (!empty($userData)) :

                                foreach ($userData as $key => $value) :
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>



                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value->user_id;  ?>">
                                            <?php if (empty($value->user_id)) {
                                                echo "N/A";
                                            } else {
                                                $returnss = get_signle_data_from('users', ['id' => $value->user_id]);
                                                
                                                if ($returnss) {
                                                    
                                                    $return1ww = $returnss->username;
                                                    echo ($return1ww);
                                                } else {
                                                    echo "N/A";
                                                }
                                            } ?>
                                        </a></td>

                                        <td class="text-center">
                                            <?php echo $value->points; ?>
                                        </td>

                                        <td class="text-center">
                                             <?php 
                                                if($value->created_at !== "0000-00-00 00:00:00"){
                                                    $date = $value->created_at;
                                                    $time = date("d-M-Y H:i", strtotime($date));
                                                }else{
                                                    $time = "0000-00-00 00:00";
                                                }
                                                ?>
                                                
                                            <?php echo $time; ?>
                                        </td>

                                        <td class="text-center">
                                            <?php if (!empty($value->admin_status)) {
                                                if ($value->admin_status == "APPROVED") {
                                            ?>
                                                    <span class="badge badge-success"><?php echo $value->admin_status; ?></span>
                                                <?php } elseif($value->admin_status == "PENDING") { ?>
                                                    <span class="badge badge-warning"><?php echo $value->admin_status; ?></span>

                                                <?php }else{ ?>
                                                    <span class="badge badge-danger"><?php echo $value->admin_status; ?></span>
                                                <?php };
                                            } else { ?>
                                                <span class="badge badge-danger">N/A</span>
                                            <?php }; ?>
                                        </td>
                                        <td>
                                            <a class="openwithreq" data-delete-url="<?php echo $value->id; ?>">
                                                <span data-toggle="modal" data-target="#withreqModal">
    													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye p-1 br-6 mb-1">
    														<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
    														<circle cx="12" cy="12" r="3" />
    													</svg>
    											</span>
    										</a>
										
                                        </td>

                                        <td class="text-center">
                                            <?php if($value->admin_status == "PENDING"){ ?>
                                            <a href="<?= SITE_URL?>Fund/change_action_status_withdraw/<?php echo $value->id; ?>/APPROVED"><p><span class="badge badge-success">Approve</span></p></a>
                                            <a href="<?= SITE_URL?>Fund/change_action_status_withdraw/<?php echo $value->id; ?>/REJECTED"><p><span class="badge badge-danger">Reject</span></p></a>
                                            <?php } elseif(($value->admin_status == "APPROVED") || ($value->admin_status == "REJECTED")){ ?>
                                            
                                             N/A
                                                
                                            <?php }?>
                                        </td>
                                        
                                        
                                    </tr>  
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                                    <div class="modal fade" id="withreqModal" role="dialog">
                                        <form method="post">
                                            <div class="modal-dialog">
                                                  <div class="modal-content">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                       <div class="modal-header">
                                                        
                                                          <h4 class="modal-title">Withdraw Request Details</h4>
                                                       </div>
                                                       <div class="modal-body">
                                                             <table class="table table-hover">
                                                              <thead>
                                                                <tr>
                                                                  <th>Name</th>
                                                                  <th>Details </th>
                                                                  <th>Name </th>
                                                                  <th>Details </th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>
                                                                <tr>
                                                                  <td>UserName</td>
                                                                  <td id="username"></td>
                                                                  <td>Request Amount</td>
                                                                  <td id="req_amnt"></td>
                                                                  <input type="hidden" value="" id="copypointcode">
                                                                </tr>
                                                                <tr>
                                                                  <td>Request Number</td>
                                                                  <td id="req_no"></td>
                                                                  <td>Payment Method</td>
                                                                  <td id="method"></td>
                                                                </tr>
                                                                <tr>
                                                                  <td>Googlepay No</td>
                                                                  <td id="method_no">
                                                                      
                                                                   
                                                                  </td>
                                                                  <input type="hidden" value="" id="copycode">
                                                                  <td>Request Date</td>
                                                                  <td id="date"></td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                  <td>Request Accepted Date</td>
                                                                  <td id="re_date"></td>
                                                                </tr>
                                                              </tbody>
                                                            </table>
                                                        </div>
                                                   
                                                  </div>
                                               </div>
                                            </div>
                                        </form>
                                    </div>
            </form>
        </div>
    </div>
</div>