<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row mt-5" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 2%">#</th>
                                <th>Game Name</th>
                                <th>Result Date</th>
                                <th>Number</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $i = 1;
                            if (!empty($resultDataList)) :
                                foreach ($resultDataList as $key => $value) :
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>
                                        <td><?=$value['game_name']?></td>
                                        <td><?=$value['date']?></td>
                                        <td><?=$value['result']?></td>
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