<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php breadcrumb_start('Category Descriptions', 'list/category', 'category_list', 'Categories');
?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="">
                                <th>#</th>
                                <th>Description</th>
                                <th>Description in tamil</th>
                                <th>Description in hindi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (!empty($catData)) :
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?>.</td>

                                    <td class="">
                                        <p class="align-self-center mb-0 ">
                                            <?php is($catData->desc, 'show'); ?>
                                        </p>
                                    </td>

                                    <td class="">
                                        <p class="align-self-center mb-0 ">
                                            <?php is($catData->tamil_desc, 'show'); ?>
                                        </p>
                                    </td>

                                    <td class="">
                                        <p class="align-self-center mb-0 ">
                                            <?php is($catData->hindi_desc, 'show'); ?>
                                        </p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>