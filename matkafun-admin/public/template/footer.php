</div>
</div>
<!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->
<?php footer_popups(); ?>
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>

<script src="<?php echo SITE_URL; ?>assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="<?php echo SITE_URL; ?>plugins/bootstrap/js/popper.min.js"></script>
<script src="<?php echo SITE_URL; ?>plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo SITE_URL; ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo SITE_URL; ?>assets/js/app.js"></script>
<!--<script src="<?php echo SITE_URL; ?>plugins/select2/select2.min.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        App.init();
        
        // Robust click-outside-to-close logic
        $(document).on('mousedown touchstart', function(e) {
            var sidebar = $('.sidebar-wrapper');
            var toggle = $('.sidebarCollapse');
            var container = $('#container');
            
            if (container.hasClass('sbar-open')) {
                // If the click was NOT on the sidebar and NOT on the toggle button
                if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 && 
                    !toggle.is(e.target) && toggle.has(e.target).length === 0) {
                    
                    container.addClass('sidebar-closed');
                    container.removeClass('sbar-open');
                    $('.overlay, .cs-overlay').removeClass('show');
                    $('html,body').removeClass('sidebar-noneoverflow');
                }
            }
        });
    });
</script>

<script src="<?php echo SITE_URL; ?>assets/js/custom.js"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->

<?php // Add Scripts For Login Page
if (check_current_page('admin/login')) : ?>
    <script src="<?php echo SITE_URL; ?>assets/js/authentication/form-1.js"></script>
<?php // Add Scripts For Main Dashboard
elseif (check_current_page('admin/home')) : ?>
    <script src="<?php echo SITE_URL; ?>plugins/apex/apexcharts.min.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/js/dashboard/dash_1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js" integrity="sha512-OKuL2kpi8zfeXcqSXnGbL6tKc9JxWmppJY4mOSn1EsngRb7fx1N5+7wOTGqu2bI5OAYL3Og7/Beg7EsWG2OBKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha512-DUC8yqWf7ez3JD1jszxCWSVB0DMP78eOyBpMa5aJki1bIRARykviOuImIczkxlj1KhVSyS16w2FSQetkD4UU2w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script type="text/javascript">
        function clickankButton() {
            var ank_market = document.getElementById('ank_market').value;
            var ank_game_id = document.getElementById('ank_game_id').value;
            var ank_date = document.getElementById('ank_date') ? document.getElementById('ank_date').value : '';
            $.ajax({
                type: "post",
                url: "<?php echo SITE_URL; ?>Admin/ank_ajax",
                dataType: "JSON",
                data: {
                    'ank_market': ank_market,
                    'ank_game_id': ank_game_id,
                    'ank_date': ank_date
                },
                cache: false,
                success: function(html) {

                    $('#zero_ank_count').html(html.zero_ank_count);
                    $('#zero_ank_sum').html(html.zero_ank_sum);
                    $('#one_ank_count').html(html.one_ank_count);
                    $('#one_ank_sum').html(html.one_ank_sum);
                    $('#two_ank_count').html(html.two_ank_count);
                    $('#two_ank_sum').html(html.two_ank_sum);
                    $('#thr_ank_count').html(html.thr_ank_count);
                    $('#thr_ank_sum').html(html.thr_ank_sum);
                    $('#four_ank_count').html(html.four_ank_count);
                    $('#four_ank_sum').html(html.four_ank_sum);
                    $('#fiv_ank_count').html(html.fiv_ank_count);
                    $('#fiv_ank_sum').html(html.fiv_ank_sum);
                    $('#six_ank_count').html(html.six_ank_count);
                    $('#six_ank_sum').html(html.six_ank_sum);
                    $('#sev_ank_count').html(html.sev_ank_count);
                    $('#sev_ank_sum').html(html.sev_ank_sum);
                    $('#eght_ank_count').html(html.eght_ank_count);
                    $('#eght_ank_sum').html(html.eght_ank_sum);
                    $('#nine_ank_count').html(html.nine_ank_count);
                    $('#nine_ank_sum').html(html.nine_ank_sum);
                }
            });
            return false;
        }
    </script>




    <script type="text/javascript">
        function clickButton() {
            var date_name = document.getElementById('win_from_date').value;
            var g_name = document.getElementById('slect_g_name_win').value;
            $.ajax({
                type: "post",
                url: "<?php echo SITE_URL; ?>Admin/win_his_ajax",
                dataType: "JSON",
                data: {
                    'date_name': date_name,
                    'g_name': g_name
                },
                cache: false,
                success: function(html) {
                    $('#msg').html(html.bdd_amnt);
                    $('#msgwin').html(html.win_amnt);
                    $('#msgprofit').html(html.profit);
                    $('#msgwithdraw').html(html.report_withdrawal);
                    $('#msgaddfunds').html(html.report_depositadmin);
                    $('#msgdeposit').html(html.report_deposit);
                }
            });
            return false;
        }
    </script>
<?php // Add Scripts For Datatable Lists
elseif (check_current_method_similar('list')) :     ?>

    <!--<script src="<?php echo SITE_URL; ?>plugins/table/datatable/datatables.js"></script>-->

    <script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>-->

    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
    <!--<script src="<?php echo SITE_URL; ?>plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>-->
    <!--<script src="<?php echo SITE_URL; ?>plugins/table/datatable/button-ext/jszip.min.js"></script>-->
    <!--<script src="<?php echo SITE_URL; ?>plugins/table/datatable/button-ext/buttons.html5.min.js"></script>-->
    <!--<script src="<?php echo SITE_URL; ?>plugins/table/datatable/button-ext/buttons.print.min.js"></script>-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="<?= SITE_URL ?>assets/js/dist/clipboard.min.js"></script>

    <script>
        function copy() {
            navigator.clipboard.writeText($('#copycode').val());
            alert("Copied Successfully");
        }

        function newcopy() {
            navigator.clipboard.writeText($('#copypointcode').val());
            alert("Copied Successfully");
        }


        function myFunction() {

            /* Get the text field */
            var copyText = document.getElementById('copycode').value;

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

            /* Alert the copied text */
            alert("Copied the text: " + copyText.value);
        }
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.openwithreq', function() {

                var show_url = $(this).attr('data-delete-url');


                $('#withreqModal').modal('show');

                $.ajax({
                    type: "post",
                    url: "<?php echo SITE_URL; ?>Fund/show_details",
                    dataType: "JSON",
                    data: {
                        'show_url': show_url
                    },
                    cache: false,
                    success: function(html) {
                        var fieldhtml = '<button class="btn" onclick="copy()"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M22 6v16h-16v-16h16zm2-2h-20v20h20v-20zm-24 17v-21h21v2h-19v19h-2z"/></svg></button>';

                        var newhtml = '<button class="btn" onclick="newcopy()"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M22 6v16h-16v-16h16zm2-2h-20v20h20v-20zm-24 17v-21h21v2h-19v19h-2z"/></svg></button>';


                        $('#username').html(html.username);
                        $('#req_amnt').html(html.points).append(newhtml);
                        $('#copypointcode').val(html.points);
                        $('#req_no').html(html.request_no);
                        $('#method').html(html.payment_method);
                        $('#method_no').html(html.payment_method_no).append(fieldhtml);
                        $('#copycode').val(html.payment_method_no);
                        $('#payment_method_no').html(html.request_no);
                        $('#date').html(html.created_at);
                        $('#re_date').html(html.modified_date);
                    }
                });
                return false;
            })
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#html5-extension').dataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#perfectPACMANscores').DataTable();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_id').dataTable();
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#winlistreport').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#fundebit').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#fundreq').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#bidhis').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#winreq').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#winhis').DataTable();
        });
    </script>
    <!--<script>-->
    <!--    $(document).ready(function () {-->

    <!--          $("select").select2();-->
    <!--       });-->
    <!--</script>-->

    <script type="text/javascript">
        $(document).ready(function() {

            $("#myrevertFunction").click(function() {
                var date = document.getElementById('bid_revert_from_date').value;
                alert("gg");
                alert(date);
                $.ajax({
                    type: "post",
                    url: "<?php echo SITE_URL; ?>Fund/revert_bid_by_click",
                    data: {
                        'date': date,
                    },
                    cache: false,
                    success: function(data) {

                        console.log();
                    }
                });
                return false;
            });




        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#starline_myrevertFunction").click(function() {
                var starline_bid_revert_date = document.getElementById('from_date').value;
                alert("gg");
                alert(starline_bid_revert_date);
                $.ajax({
                    type: "post",
                    url: "<?php echo SITE_URL; ?>Starline/revert_bid_by_click",
                    data: {
                        'starline_bid_revert_date': starline_bid_revert_date,
                    },
                    cache: false,
                    success: function(data) {

                        console.log();
                    }
                });
                return false;
            });




        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#gali_myrevertFunction").click(function() {
                var gali_bid_revert_date = document.getElementById('from_date').value;
                alert("gg");
                alert(gali_bid_revert_date);
                $.ajax({
                    type: "post",
                    url: "<?php echo SITE_URL; ?>Galidisawar/revert_bid_by_click",
                    data: {
                        'gali_bid_revert_date': gali_bid_revert_date,
                    },
                    cache: false,
                    success: function(data) {

                        console.log();
                    }
                });
                return false;
            });




        });
    </script>
    <script>
        $(document).ready(function() {


            $('#select_pana').change(function() {



                var dpid = $(this).val();


                output = [],
                    Numbers = dpid.toString();


                for (var i = 0, len = Numbers.length; i < len; i += 1) {
                    output.push(+Numbers.charAt(i));
                }
                for (var i = 0, sum = 0; i < output.length; sum += output[i++]);

                var final = sum % 10;


                $("#result_new").val(final);



            });

        });
    </script>
    <script>
        $(document).ready(function() {

            $('#starline_pana').change(function() {

                var spid = $(this).val();

                outputs = [],
                    sNumbers = spid.toString();

                for (var i = 0, len = sNumbers.length; i < len; i += 1) {
                    outputs.push(+sNumbers.charAt(i));
                }
                for (var i = 0, sums = 0; i < outputs.length; sums += outputs[i++]);

                var finalvs = sums % 10;
                $("#starline_fmod").val(finalvs);


            });

        });
    </script>

    <script type="text/javascript">
        function clickrefresh() {

            $("#prediv").load(" #prediv > *");
        }
    </script>

    <script type="text/javascript">
        function clickpredictionButton() {

            var pre_close_pana = document.getElementById('pre_close_pana').value;
            var pre_open_pana = document.getElementById('pre_open_pana').value;
            var pre_session = document.getElementById('pre_session').value;
            var pre_game_id = document.getElementById('pre_game_id').value;
            var pre_from_date = document.getElementById('pre_from_date').value;

            var id_numbers = [];
            $.ajax({
                type: "post",
                url: "<?php echo SITE_URL; ?>Prediction/data_by_filter",
                // dataType: "JSON",
                data: {
                    'pre_close_pana': pre_close_pana,
                    'pre_open_pana': pre_open_pana,
                    'pre_session': pre_session,
                    'pre_from_date': pre_from_date,
                    'pre_game_id': pre_game_id,
                },
                cache: false,
                success: function(data) {
                    var obj = jQuery.parseJSON(data);
                    var bidAmt = 0;
                    var winAmt = 0;
                    if (obj.length) {
                        var i = obj.length;
                        $.each(obj, function(key, val) {
                            bidAmt += parseInt(val.bid_points);
                            winAmt += parseInt(val.win_points);
                            var html = '<tr>';
                            html += '<td>' + (i--) + '</td>';
                            html += '<td>' + val.bidded_at + '</td>';
                            html += '<td>' + val.mobile + '</td>';
                            html += '<td>' + val.username + '</td>';
                            html += '<td>' + val.game_name + '</td>';
                            html += '<td>' + val.game_type + '</td>';
                            html += '<td>' + val.session + '</td>';
                            html += '<td>' + val.open_panna + '</td>';
                            html += '<td>' + val.open_digit + '</td>';
                            html += '<td>' + val.close_panna + '</td>';
                            html += '<td>' + val.close_digit + '</td>';
                            html += '<td>' + val.bid_points + '</td>';
                            html += '<td>' + val.win_points + '</td></tr>';
                            $('#dataTable').prepend(html);
                        });

                        var state = '<h5> Total Bid Amount ₹<b>' + bidAmt + '</b></h5>';
                        state += '<h5> Total Winning Amount ₹<b>' + winAmt + '</b></h5>';
                        $('#winForm').prepend(state);
                    } else {
                        var html = '<tr> No Winner </tr>';
                        $('#dataTable').prepend(html);
                    }


                    $.ajax({
                        type: "post",
                        url: "<?= SITE_URL ?>Prediction/list_prediction",
                        data: 'page=' + id_numbers,
                        success: successHandler, // handler if second request succeeds 
                        dataType: dataType,
                        success: function(data) {
                            console.log(data);



                        }
                    });

                }
            });
            return false;
        }
    </script>



    <script type="text/javascript">
        function clickreportuserbid() {

            var report_bid_game_type = document.getElementById('report_bid_game_type').value;
            var report_bid_game_id = document.getElementById('report_bid_game_id').value;
            var report_bid_from_date = document.getElementById('report_bid_from_date').value;

            var total_bid_data = [];
            $.ajax({
                type: "post",
                url: "<?php echo SITE_URL; ?>ReportAjax/report_user_bid_his",
                // dataType: "JSON",
                data: {
                    'report_bid_game_type': report_bid_game_type,
                    'report_bid_game_id': report_bid_game_id,
                    'report_bid_from_date': report_bid_from_date,
                },
                cache: false,
                success: function(data) {
                    total_bid_data = data;
                    // var src ="<?= SITE_URL ?>Prediction/list_prediction?id_numbers="+id_numbers;
                    // window.location.href=id_numbers;


                    $.ajax({
                        type: "post",
                        url: "<?= SITE_URL ?>Prediction/list_prediction",
                        data: 'page=' + id_numbers,
                        success: successHandler, // handler if second request succeeds 
                        dataType: dataType,
                        success: function(data) {
                            console.log(data);


                        }
                    });

                }
            });
            return false;
        }
    </script>
    <script>
        $('#multi-column-ordering').DataTable({
            dom: '<"row"<"col-md-12"<"row_sh"<"col-md-4"f><"col-md-2"l> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: [{
                    extend: 'copy',
                    className: 'btn'
                },
                {
                    extend: 'csv',
                    className: 'btn'
                },
                {
                    extend: 'excel',
                    className: 'btn'
                },
                {
                    extend: 'print',
                    className: 'btn'
                }
            ],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "lengthMenu": [10, 20, 50, 100],
            "pageLength": 10
        });

        $('#html5-extension').DataTable({

            "lengthMenu": [10, 20, 50],
            "pageLength": 10
        });
    </script>
    <script async src="https://guteurls.de/guteurls.js" selector=".linkPreview"></script>

    <script>
        window.onload = () => {
            $('.guteurlsBox > div.guteurlsImg201610').addClass('bg-transparent');
            $('.linkPreview').addClass('w-50');
            $('.guteurlsGU').remove();
        }
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.deleteConfirm', function() {

                var delete_url = $(this).attr('data-delete-url');
                // alert(delete_url);
                $('#deleteConfirmModel').find('a').attr('href', delete_url);
                $('#deleteConfirmModel').modal('show');
            })
        });
    </script>


<?php // Add Scripts For Form Pages
elseif (check_current_method_similar('add') or check_current_method_similar('edit')) : ?>
    <script src="<?php echo SITE_URL; ?>plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/js/scrollspyNav.js"></script>
    <script src="<?php echo SITE_URL; ?>plugins/flatpickr/flatpickr.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/js/components/ui-accordions.js"></script>
    <script src="<?php echo SITE_URL; ?>plugins/select2/select2.min.js"></script>

    <script>
        $(document).ready(function() {


            $('#slect_bid_pana_new').change(function() {



                var bidid = $(this).val();


                outputss = [],
                    Numberssds = bidid.toString();


                for (var i = 0, len = Numberssds.length; i < len; i += 1) {
                    outputss.push(+Numberssds.charAt(i));
                }
                for (var i = 0, sumssd = 0; i < outputss.length; sumssd += outputss[i++]);

                var finalbid = sumssd % 10;

                $("#result_new_bid").val(finalbid);



            });

        });
    </script>



    <script>
        $(document).ready(function() {
            $('#category').on('change', function() {

                var category_id = this.value;

                $.ajax({
                    type: 'post',
                    data: {
                        category_id: category_id
                    },

                    url: '<?php echo SITE_URL ?>Category/ajax_add_subcategory',
                    type: "POST",
                    data: {
                        category_id: category_id
                    },
                    cache: false,
                    success: function(data) {
                        $("#subcategory").html(data);
                        // $("#suggesstion-box").html(data).show();
                        console.log(data);

                    }



                });
            });
        });
    </script>

    <!-- <script>
		$(document).ready(function() {

			$('#vendorservices_add_category').on('change', function() {

				//var category_id = this.value;
				var category_id = $(this).val();

				alert(category_id);
				$.ajax({
					type: 'post',
					data: {
						category_id: category_id
					},
					url: '<?php echo SITE_URL ?>Vendorservices/ajax_get_services_by_category_id',
					success: function(data) {
						$("#vendorservices_add_service").html(data);
						// $("#suggesstion-box").html(data).show();
						console.log(data);
					}
				});
			});
		});
	</script> -->

    <!-- <script>
		var secondUpload = new FileUploadWithPreview('mySecondImage')
	</script> -->
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                // console.error(error);
            });
    </script>




    <script>
        if ($('#editor1').length) {
            CKEDITOR.replace('editor1');
        }
        if ($('#editor2').length) {
            CKEDITOR.replace('editor2');
        }

        if ($('.tagging').length || $('.withoutTagging').length) {
            $(".tagging").select2({
                tags: true,
                placeholder: "Make a Selection"
            });
            $(".withoutTagging").select2({
                placeholder: "Make a Selection"
            });
        }

        // Property Add Show Hide Possession Date
        if ($('#pdate').length) {
            $('#rtmo').click(function(e) {
                $('#pdate').slideUp();
            });
            $('#uc').click(function(e) {
                $('#pdate').slideDown();
            });
        }

        // Add FlatPickr on FollowDate
        if ($('#myFlatDate').length) {
            var f2 = flatpickr(document.querySelector('#myFlatDate'), {
                enableTime: true,
                dateFormat: "Y-m-d H:i:s",
            });
        }
    </script>
<?php endif; ?>
</body>

</html>