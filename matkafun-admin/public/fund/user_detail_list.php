<div class="container">
    <div class="main-body">

        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">

                <div class="card">
                    <div class="card  mt-3">
                        <div class="d-flex flex-column align-items-center text-center">
                            <?php if ($userperData->profile_image != '') { ?>
                                <img src="<?php echo $userperData->profile_image; ?>" alt="Admin" class="rounded-circle" width="150">
                            <?php } else { ?>
                                <img src="<?php echo SITE_URL ?>assets/img/adminsss.png" alt="Admin" class="rounded-circle" width="150">
                            <?php } ?>

                            <div class="mt-3">
                                <h4><?php echo $userperData->username ?></h4>
                                <p class="text-secondary mb-1"><?php echo $userperData->email; ?></p>
                                <p class="text-secondary mb-1"> <?php echo $userperData->mobile; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4  mb-3">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">Security Pin:</h6>
                            <span class="text-secondary"><?php echo $userperData->pin; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">Active</h6>
                            <span class="badge outline-badge-danger">Yes</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">T P</h6>
                            <span class="badge outline-badge-danger">No</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

                            <span class="badge outline-badge-danger">Delete</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">Available balance:</h6>
                            <span class="text-secondary"><?php echo $userperData->balance; ?></span>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-4  mb-3">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

                            <span class="badge badge-success">Add Fund</span>

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

                            <span class="badge badge-danger">Withdraw Fund</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <a href="<?php echo SITE_URL ?>payment_list/user/<?php echo $userperData->id; ?>">
                                <h6 class="mb-0">Payment Information</h6>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

                            <a href="<?php echo SITE_URL ?>fund_credit_list/user/<?php echo $userperData->id; ?>">
                                <h6 class="mb-0">Fund Credit Report</h6>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <a href="<?php echo SITE_URL ?>fund_dedit_list/user/<?php echo $userperData->id; ?>">
                                <h6 class="mb-0">Fund Debit Report</h6>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <a href="<?php echo SITE_URL ?>fund_req_list/user/<?php echo $userperData->id; ?>">
                                <h6 class="mb-0">Fund Request List</h6>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-10">

                <div class="card mt-10">

                    <div class="card-body-profile">
                        <h6 class="mb-0">Personal Information </h6>
                        <br>

                        <div class="row">
                            <div class="col-md-6">

                                <p class="mb-0">Full Name:


                                    <?php echo $userData['full_name'] ?></p>

                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">Email:

                                    <?php echo $userData['email'] ?></p>


                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">

                                <p class="mb-0">Mobile:

                                    <?php echo $userData['phone'] ?></p>

                            </div>
                            <div class="col-md-6">

                                <p class="mb-0">Password:

                                    <?php echo $userperData->password; ?></p>


                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">District Name:

                                    <?php echo $userData['district'] ?></p>

                            </div>
                            <div class="col-md-6">

                                <p class="mb-0">Flat/Plot No. :

                                    <?php echo $userData['flat_no'] ?></p>


                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">

                                <p class="mb-0">Address Lane 1:

                                    <?php echo $userData['address_lane_1'] ?></p>

                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">Address Lane 2:
                                    <?php echo $userData['address_lane_2'] ?></p>


                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">

                                <p class="mb-0">Area:

                                    <?php echo $userData['area'] ?></p>
                            </div>
                            <div class="col-md-6">

                                <p class="mb-0">Pin Code:

                                    <?php echo $userData['pincode'] ?></p>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">

                                <p class="mb-0">State Name:

                                    <?php echo $userData['state'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">Creation Date:
                                    <?php echo $userData['created_date'] ?></p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>