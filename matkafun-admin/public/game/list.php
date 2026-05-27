<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('games', 'add/game', 'game_add'); ?>
<link rel="stylesheet" href="/other.css">

<style>
    /* Ensure full-width table fits without scrollbars */
    .widget-content {
        padding: 0 !important;
        margin: 0 !important;
    }

    .table-responsive {
        overflow-x: auto !important;
        width: 100% !important;
    }

    .table th,
    .table td {
        white-space: nowrap;
        vertical-align: middle !important;
        text-align: center;
        padding: 8px 6px !important;
    }

    .table thead th {
        background: #f8f9fa;
        font-weight: 600;
        font-size: 14px;
    }

    .table p {
        margin: 0;
    }

    .badge {
        font-size: 12px;
    }

    ul.table-controls {
        padding-left: 0;
        margin-bottom: -0;
        list-style: none;
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    ul.table-controls li a svg {
        vertical-align: middle;
    }

    /* Prevent any scrollbars in layout */
    html,
    body {
        overflow-x: hidden !important;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    #cancel-row {
        margin: 0 !important;
    }

    .layout-spacing {
        padding: 0 !important;
    }

    /* ✅ Extend box till bottom of screen */
    .widget-content-area {
        min-height: calc(100vh - 140px) !important;
        background: #fff;
        border-radius: 12px;
        padding-bottom: 30px !important;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
        .widget-content-area {
            min-height: calc(100vh - 120px) !important;
            padding-bottom: 40px !important;
        }

        .table th,
        .table td {
            font-size: 13px !important;
            padding: 6px 4px !important;
        }
    }
</style>

<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form method="post">
                <div class="table-responsive my-3">
                    <table id="multi-column-ordering" class="style-3 table table-hover table-bordered" style="width:100%">
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
                            <?php
                            $i = 1;
                            if (!empty($ratingsData)) :
                                foreach ($ratingsData as $key => $value) :
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>

                                        <td><?php echo ucwords($value['name']); ?></td>

                                        <td><?php echo $value['open_time']; ?></td>

                                        <td><?php echo $value['close_time']; ?></td>

                                        <td>
                                            <?php if ($value['status'] == 1) { ?>
                                                <a href="<?= SITE_URL; ?>Game/change_status_game/<?= $value['id']; ?>/inactive">
                                                    <span class="badge badge-success">Active</span>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?= SITE_URL; ?>Game/change_status_game/<?= $value['id']; ?>/active">
                                                    <span class="badge badge-danger">Inactive</span>
                                                </a>
                                            <?php } ?>
                                        </td>

                                        <td>
                                            <?php
                                            $curnt_time = date("H:i:s");
                                            $close_time = $value['close_time'];
                                            if ($curnt_time < $close_time) {
                                                echo '<span class="badge outline-badge-success">Market Running</span>';
                                            } else {
                                                echo '<span class="badge outline-badge-danger">Market Closed</span>';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <ul class="table-controls">
                                                <li>
                                                    <a href="<?= SITE_URL . 'edit/game/' . $value['id']; ?>" class="bs-tooltip" data-toggle="tooltip" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.5"
                                                                d="M12.2535 18.4243C11.9606 18.1314 11.4857 18.1314 11.1928 18.4243C10.8999 18.7172 10.8999 19.1921 11.1928 19.485L12.2535 18.4243ZM17.5083 18.9546L18.0387 19.485L17.5083 18.9546Z"
                                                                fill="#1C274C" />
                                                            <path
                                                                d="M3.19792 20.6782L4 20.4108L6.47918 19.5844C7.25352 19.3263 7.6407 19.1973 8.00498 19.0237C8.43469 18.8189 8.84082 18.5679 9.21616 18.2751C9.53436 18.0269 9.82294 17.7383 10.4001 17.1612L18.9213 8.63993L19.8482 7.71306C21.3839 6.17735 21.3839 3.68748 19.8482 2.15178C18.3125 0.616074 15.8226 0.616074 14.2869 2.15178L13.3601 3.07866L4.83882 11.5999"
                                                                stroke="#1C274C" stroke-width="1.5" />
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= SITE_URL ?>Game/change_delete/<?= $value['id']; ?>" data-toggle="tooltip" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <path d="M18.0001 4H1" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                                            <path d="M16.3334 6.5L15.8735 13.3991C15.6965 16.054 15.608 17.3815 14.743 18.1907C13.878 19 12.5476 19 9.88676 19H9.1134C6.4526 19 5.1222 19 4.25719 18.1907C3.39218 17.3815 3.30368 16.054 3.12669 13.3991L2.66675 6.5"
                                                                stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
