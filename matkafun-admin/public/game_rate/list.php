<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('game_rate', 'add/game_rate', 'game_rate_add'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 2%">#</th>
                                <th>Name</th>
                                <th>Today Open</th>
                                <th>Today Close</th>
                                <th>Status</th>
                                <th>Market Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (!empty($ratingsData)) :

                                foreach ($ratingsData as $key => $value) :
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>

                                        <td>
                                            <p>
                                                <?php echo ucwords($value['name']); ?>
                                            </p>
                                        </td>

                                        <td>
                                            <p>
                                                <?php echo ($value['open_time']); ?>
                                            </p>
                                        </td>

                                        <td class="">
                                            <p>
                                                <?php echo ($value['close_time']); ?>
                                            </p>
                                        </td>
                                        <td class="">

                                            <span class="badge px-2 py-1 badge-<?php is(get_status($value['status'])->class, 'show'); ?>">
                                                <?php is(get_status($value['status'])->title, 'show'); ?>
                                            </span>

                                            <div class="btn-group" id="btns<?php echo $i ?>">
                                                <div class="btn-group">
                                                    <button type="button" class="badge px-2 py-1 badge dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Edit<span class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu">

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <li><a href="<?= SITE_URL; ?>Game/change_status_game/<?= $value['id']; ?>/inactive">Inactive</a></li>
                                                        <?php } else { ?>
                                                            <li><a href="<?= SITE_URL; ?>Game/change_status_game/<?= $value['id']; ?>/active">Active</a></li>
                                                        <?php        }   ?>
                                                    </ul>
                                                </div>
                                            </div>

                                        </td>
                                        <td class="">
                                            <p>
                                                <?php if ($value['market_status'] == 1) { ?>
                                                    <span class="badge outline-badge-success">Market Running</span>
                                                <?php } else { ?>
                                                    <span class="badge outline-badge-danger">Market Closed</span>
                                                <?php        }   ?>

                                            </p>
                                        </td>

                                        <td>
                                            <ul class="table-controls">

                                                <li>
                                                    <a class="deleteConfirm" data-delete-url="<?php echo SITE_URL . 'delete/game/' . $value['id']; ?>">
                                                        
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M18.0001 4H1" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                                            <path d="M16.3334 6.5L15.8735 13.3991C15.6965 16.054 15.608 17.3815 14.743 18.1907C13.878 19 12.5476 19 9.88676 19H9.1134C6.4526 19 5.1222 19 4.25719 18.1907C3.39218 17.3815 3.30368 16.054 3.12669 13.3991L2.66675 6.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                                            <path opacity="0.5" d="M7 9L7.5 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                                            <path opacity="0.5" d="M12 9L11.5 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                                            <path opacity="0.5" d="M4 4C4.05588 4 4.08382 4 4.10915 3.99936C4.93259 3.97849 5.65902 3.45491 5.93922 2.68032C5.94784 2.65649 5.95667 2.62999 5.97434 2.57697L6.07143 2.28571C6.15431 2.03708 6.19575 1.91276 6.25071 1.8072C6.47001 1.38607 6.87574 1.09364 7.34461 1.01877C7.46213 1 7.59317 1 7.85526 1H11.1447C11.4068 1 11.5379 1 11.6554 1.01877C12.1243 1.09364 12.53 1.38607 12.7493 1.8072C12.8043 1.91276 12.8457 2.03708 12.9286 2.28571L13.0257 2.57697C13.0433 2.62992 13.0522 2.65651 13.0608 2.68032C13.341 3.45491 14.0674 3.97849 14.8909 3.99936C14.9162 4 14.9441 4 15 4" stroke="#1C274C" stroke-width="1.5" />
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