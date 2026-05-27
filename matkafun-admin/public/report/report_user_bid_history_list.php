<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mb-4">
                            <label>Date</label>
                            <input type="date" class="form-control" id="report_bid_from_date" name="from_date" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-4 reloaded-divs">
                            <label>Game Name</label>
                            <select class="selectpicker form-control" name="game_id" title="Select Game" id="report_bid_game_id" value="">
                                <option value="All">All</option>
                                <?php foreach ($games as $value) :
                                    $category_idss = $_POST['game_id'] ?? '';
                                ?>
                                    <option value="<?php is($value['id'], 'show'); ?>" <?php echo ($value['id'] == $category_idss) ? "selected" : ""; ?>>
                                        <?php is($value['name'], 'showCapital'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group mb-4 reloaded-divs">
                            <label>Game Type</label>
                            <select class="selectpicker form-control" name="game_type" title="Select Game Type" id="report_bid_game_type" value="">
                                <option value="All">All</option>
                                <option value="single_digit">Single Digit</option>
                                <option value="jodi_digit">Jodi Digit</option>
                                <option value="single_panna">Single Panna</option>
                                <option value="double_panna">Double Panna</option>
                                <option value="triple_panna">Triple Panna</option>
                                <option value="half_sangam">Half Sangam</option>
                                <option value="full_sangam">Full Sangam</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 text-centre">
                        <button type="submit" class="btn btn-primary" style="margin-top:30px;" name="filter" value="filter">Submit</button>
                        <button class="btn btn-danger" id="clearrr_cat" style="color:azure; margin-top:30px;"><a href=" <?= SITE_URL; ?>report_user_bid_history_list/report">Clear</a></button>
                    </div>
                </div>
            </form>
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 2%">#</th>
                                <th>Time</th>
                                <th>Username</th>
                                <th>Game Name</th>
                                <th>Game Type</th>
                                <th>Session</th>
                                <th>Open Pana</th>
                                <th>Open Result</th>
                                <th>Close Pana</th>
                                <th>Close Result</th>
                                <th>Points</th>
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
                                        <td class="text-center"><?=$value['bidded_at']?></td>
                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>"><?=$value['user_name']?></a></td>
                                        <td class="text-center"><?=$value['game_name']?></td>
                                        <td class="text-center"><?=$value['game_type']?></td>
                                        <td class="text-center"><?=$value['session']?></td>
                                        <td class="text-center"><?=$value['open_panna']?></td>
                                        <td class="text-center"><?=$value['open_digit']?></td>
                                        <td class="text-center"><?=$value['close_panna']?></td>
                                        <td class="text-center"><?=$value['close_digit']?></td>
                                        <td class="text-center"><?=$value['bid_points']?></td>
                                        <td>
                                            <ul class="table-controls">
                                                <li>
                                                    <a href="<?php echo SITE_URL . 'edit/report/' . $value['id'];  ?>" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                        
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.5" d="M12.2535 18.4243C11.9606 18.1314 11.4857 18.1314 11.1928 18.4243C10.8999 18.7172 10.8999 19.1921 11.1928 19.485L12.2535 18.4243ZM17.5083 18.9546L18.0387 19.485L18.0387 19.485L17.5083 18.9546ZM3.04537 4.49167L3.5757 5.022L3.5757 5.022L3.04537 4.49167ZM2.51504 10.8072C2.80794 11.1001 3.28281 11.1001 3.5757 10.8072C3.8686 10.5143 3.8686 10.0394 3.5757 9.74652L2.51504 10.8072ZM10.2769 3.04537L10.8072 3.5757C10.9478 3.43505 11.0269 3.24428 11.0269 3.04537C11.0269 2.84646 10.9478 2.65569 10.8072 2.51504L10.2769 3.04537ZM4.49167 3.04537L3.96134 2.51504L3.96134 2.51504L4.49167 3.04537ZM18.9546 11.7231L19.485 11.1928C19.3443 11.0522 19.1535 10.9731 18.9546 10.9731C18.7557 10.9731 18.565 11.0522 18.4243 11.1928L18.9546 11.7231ZM18.9546 17.5083L18.4243 16.978L18.4243 16.978L18.9546 17.5083ZM7.33603 4.92553C7.04314 5.21843 7.04314 5.6933 7.33603 5.98619C7.62892 6.27909 8.1038 6.27909 8.39669 5.98619L7.33603 4.92553ZM16.0138 13.6033C15.7209 13.8962 15.7209 14.3711 16.0138 14.664C16.3067 14.9569 16.7816 14.9569 17.0745 14.664L16.0138 13.6033ZM3.96134 2.51504L2.51504 3.96134L3.5757 5.022L5.022 3.5757L3.96134 2.51504ZM18.0387 19.485L19.485 18.0387L18.4243 16.978L16.978 18.4243L18.0387 19.485ZM11.1928 19.485C11.8596 20.1518 12.4119 20.7063 12.9081 21.0849C13.4217 21.4767 13.9622 21.75 14.6157 21.75L14.6157 20.25C14.422 20.25 14.1981 20.1824 13.818 19.8924C13.4206 19.5892 12.9503 19.1211 12.2535 18.4243L11.1928 19.485ZM16.978 18.4243C16.2812 19.1211 15.8109 19.5892 15.4135 19.8924C15.0334 20.1824 14.8094 20.25 14.6157 20.25L14.6157 21.75C15.2693 21.75 15.8098 21.4767 16.3233 21.0849C16.8195 20.7063 17.3719 20.1518 18.0387 19.485L16.978 18.4243ZM2.51504 3.96134C1.84824 4.62814 1.29367 5.18046 0.915077 5.67666C0.523281 6.19017 0.25 6.73073 0.25 7.38426L1.75 7.38426C1.75 7.19057 1.81761 6.96662 2.10761 6.58654C2.41081 6.18914 2.87892 5.71878 3.5757 5.022L2.51504 3.96134ZM3.5757 9.74652C2.87892 9.04974 2.41081 8.57937 2.10761 8.18198C1.81761 7.8019 1.75 7.57795 1.75 7.38426L0.25 7.38426C0.25 8.03779 0.523281 8.57835 0.915078 9.09186C1.29367 9.58806 1.84824 10.1404 2.51504 10.8072L3.5757 9.74652ZM10.8072 2.51504C10.1404 1.84824 9.58806 1.29367 9.09186 0.915077C8.57835 0.52328 8.03779 0.25 7.38426 0.25L7.38426 1.75C7.57795 1.75 7.8019 1.81761 8.18199 2.10761C8.57938 2.41081 9.04974 2.87892 9.74652 3.5757L10.8072 2.51504ZM5.022 3.5757C5.71878 2.87892 6.18914 2.41081 6.58654 2.10761C6.96662 1.81762 7.19057 1.75 7.38426 1.75L7.38426 0.25C6.73073 0.25 6.19018 0.52328 5.67666 0.915077C5.18046 1.29367 4.62814 1.84824 3.96134 2.51504L5.022 3.5757ZM18.4243 12.2535C19.1211 12.9503 19.5892 13.4206 19.8924 13.818C20.1824 14.1981 20.25 14.422 20.25 14.6157L21.75 14.6157C21.75 13.9622 21.4767 13.4217 21.0849 12.9081C20.7063 12.4119 20.1518 11.8596 19.485 11.1928L18.4243 12.2535ZM19.485 18.0387C20.1518 17.3719 20.7063 16.8195 21.0849 16.3233C21.4767 15.8098 21.75 15.2693 21.75 14.6157L20.25 14.6157C20.25 14.8094 20.1824 15.0334 19.8924 15.4135C19.5892 15.8109 19.1211 16.2812 18.4243 16.978L19.485 18.0387ZM9.74652 2.51504L7.33603 4.92553L8.39669 5.98619L10.8072 3.5757L9.74652 2.51504ZM18.4243 11.1928L16.0138 13.6033L17.0745 14.664L19.485 12.2535L18.4243 11.1928Z" fill="#1C274C" />
                                                            <path d="M3.19792 20.6782L4 20.4108L6.47918 19.5844C7.25352 19.3263 7.6407 19.1973 8.00498 19.0237C8.43469 18.8189 8.84082 18.5679 9.21616 18.2751C9.53436 18.0269 9.82294 17.7383 10.4001 17.1612L18.9213 8.63993L19.8482 7.71306C21.3839 6.17735 21.3839 3.68748 19.8482 2.15178C18.3125 0.616074 15.8226 0.616074 14.2869 2.15178L13.3601 3.07866L4.83882 11.5999C4.26166 12.1771 3.97308 12.4656 3.7249 12.7838C3.43213 13.1592 3.18114 13.5653 2.97634 13.995C2.80273 14.3593 2.67368 14.7465 2.41556 15.5208L1.58917 18L1.32181 18.8021M3.19792 20.6782L2.39584 20.9456C2.01478 21.0726 1.59466 20.9734 1.31063 20.6894C1.0266 20.4053 0.927428 19.9852 1.05445 19.6042L1.32181 18.8021M3.19792 20.6782L1.32181 18.8021" stroke="#1C274C" stroke-width="1.5" />
                                                            <path opacity="0.5" d="M13.3601 3.07861C13.3601 3.07861 13.476 5.04823 15.2139 6.78613C16.9518 8.52403 18.9214 8.63989 18.9214 8.63989" stroke="#1C274C" stroke-width="1.5" />
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
            </form>
        </div>
    </div>
</div>