<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="loader"></div>
<div class="row mt-3" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">
			<form class="p-3" method="post">
				<div class="row">
					<div class="col-md-2 form-group mb-6">
						<div class="form-group mb-6">
							<label>Date</label>
							<input type="date" class="form-control" id="from_date_new" name="from_date_new" placeholder="Date" value="<?php echo date("Y-m-d"); ?>">
						</div>
					</div>
					<div class="col-md-4 form-group mb-6">
						<div class="form-group mb-6">
                            <label>Game Name</label>
                            <select class="selectpicker form-control" name="game_id_gali" title="Select Game" id="game_id_gali" value="" required>
                            	<option value="">Select Game</option>
                            	<?php foreach ($games as $value) :?>
                            		<option value="<?php echo($value['id']); ?>">
                            			<?php is($value['name'], 'showCapital'); ?>(<?php echo $value['time'];?>)</option>
                            	<?php endforeach; ?>
                            </select>	
						</div>
					</div>
					<div class="col-md-2 form-group mb-6">
						<div class="form-group mb-6">
                            <button type="submit" class="btn btn-primary" id="dib_win_filter" style="margin-top:30px;" name="pre_filter" onclick="return clickCheckResult();" value="pre_filter">Go</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row mt-3" id="resultDeclare" style="display:none">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">
		    <h5>Declare Result</h5>
			<form class="p-3" method="post">
				<div class="row" id ="select_right_digit" style="display:none">
					<div class="col-md-3">
						<div class="form-group mb-6">
							<label>Right Digit</label>
							<select class="selectpicker form-control" data-live-search="true"  name="pana" title="Select Right Digit" id="select_gali_right_digit" value="" required>
							    <option value="">Select</option>
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
							</select>
							  
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group mb-6">
							<label>Left Digit</label>
								<select class="selectpicker form-control" data-live-search="true"  name="result" title="Select Left Digit" id="left_digit_result" value="" required>
							    <option value="">Select</option>
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
							</select>
						</div>
					</div>
					<div class="col-md-2">
        				<button type="submit" style="margin-top:30px;" class="btn btn-primary" id="dib_win_filter" name="pre_filter" value="pre_filter"  onclick="return clickshowwinButton_new();">Show Winner List</button>
			    	</div>
			    	<div class="col-md-2">
            			<button type="submit" style="margin-top:30px;" class="btn btn-primary" name="addresult" value="addresult"  onclick="return clickresultdeclareButton();">Declare</button>
			    	</div>
				</div>
				<div class = "row" id="declaredResult" style="display:none">
				    <div class="col-md-3">
						<div class="form-group mb-6">
							<label>Right Digit</label>
							<input type="text" class="form-control" id="selected_panna" name="panna" placeholder="Right Digit" value="" readonly>
						</div>
					</div>
				    <div class="col-md-3">
						<div class="form-group mb-6">
							<label>Left Digit</label>
							<input type="text" class="form-control" id="selected_digit" name="result" placeholder="Left Digit" value="" readonly>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="no_winner" style="display:none"><label>No Winner Found</label></div>
<div class="row" id="winner_list" style="display:none">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">
		    <button class="primary">Winner List</button>
			<form method="post" id="result_win_list">
				<div class="table-responsive mb-4 mt-4">
					<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
						<thead>
							<tr>
							   <th style="width: 2%">#</th>
                                <th>Date</th>
                                <th>User Phone</th>
                                <th>User Name</th>
                                <th>Game Name</th>
                                <th>Game Type</th>
                                <th>Right Digit</th>
                                <th>Left Digit</th>
                                <th>Bid Points</th>
                                <th>Win Points</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody id="result_dataTable">
						
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row" id="resultData" style="display:block">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">
			<form method="post" id="result_declare_form">
				<button class="primary">Result Date : <?php echo date("d/m/Y"); ?></button></a>
				<div class="table-responsive mb-4 mt-4">
					<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
						<thead>
							<tr class="text-center">
								<th style="width: 2%">#</th>
								<th>Game Name</th>
								<th>Time</th>
								<th>Digit</th>
							</tr>
						</thead>
						<tbody id="declare_result">
						
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="no_result" style="display:none"><label>No Result Found</label></div>

<script type="text/javascript">

$( document ).ready(function() {
   fetchResults();
});

function clickCheckResult(){
    playLoader();
    var game_id_gali=document.getElementById('game_id_gali').value;
    var from_date_new=document.getElementById('from_date_new').value;
    var resultDeclare=document.getElementById('resultDeclare');
    var select_right_digit=document.getElementById('select_right_digit');
    var declaredResult=document.getElementById('declaredResult');
    
    

    
    $.ajax({
        type:"post",
        url:"<?php echo SITE_URL; ?>Galidisawar/check_result",
        // dataType: "JSON",
        data: 
        {  
            'from_date_new' :from_date_new,
            'game_id_gali' :game_id_gali
        },
        cache:false,
        success: function (data) 
        {
            
            stopLoader();
            var objss = jQuery.parseJSON(data);
            var bidAmtss = 0;
            var winAmtss = 0;
            if(objss.panna){
                declaredResult.style.display = "block";
                resultDeclare.style.display = "block";
                select_right_digit.style.display = "none";
                $('#selected_panna').val(objss.panna);
                $('#selected_digit').val(objss.digit);
            }
            else{
                declaredResult.style.display = "none";
                resultDeclare.style.display = "block";
                select_right_digit.style.display = "block";
            }
        }
    });
    return false;
}

  function clickshowwinButton_new(){
      
     
      
    playLoader();
    var right_digit=document.getElementById('select_gali_right_digit').value;
    var game_id_gali=document.getElementById('game_id_gali').value;
    var from_date_new=document.getElementById('from_date_new').value;
    var left_digit_result=document.getElementById('left_digit_result').value;
    
    var winner_list=document.getElementById('winner_list');
    var no_winner = document.getElementById('no_winner');
     $('#result_dataTable').empty();
    
    
    var win_data = [];
    $.ajax({
        type:"post",
        url:"<?php echo SITE_URL; ?>Galidisawar/show_win_ajax",
        // dataType: "JSON",
        data: 
        {  
            'right_digit' :right_digit,
            'game_id_gali' :game_id_gali,
            'from_date_new' :from_date_new,
            'left_digit_result' :left_digit_result,
        },
        cache:false,
        success: function (data) 
        {
            
            stopLoader();
            var objss = jQuery.parseJSON(data);
            
            
            var bidAmtss = 0;
            var winAmtss = 0;
            if(objss.length){
                winner_list.style.display = "block";
                no_winner.style.display = "none";
                var i = objss.length;
                $.each(objss, function(keys,vals) {
                    bidAmtss += parseInt(vals.bid_points);
                    winAmtss += parseInt(vals.win_points);
                    var edit_url = '<?php echo SITE_URL; ?>galidisawar/edit_bid_history_gali_disawar/'+vals.id;
                    var user_url = '<?php echo SITE_URL;?>user_detail_list/user/'+vals.user_id;
                    var htmlss = '<tr>';
                    htmlss += '<td>'+(i--)+'</td>';
                    htmlss += '<td>'+vals.bidded_at+'</td>';
                    htmlss += '<td><a href="'+user_url+'">'+vals.mobile+'</a></td>';
                    htmlss += '<td><a href="'+user_url+'">'+vals.username+'</a></td>';
                    htmlss += '<td>'+vals.game_name+'</td>';
                    htmlss += '<td>'+vals.game_type+'</td>';
                    htmlss += '<td>'+vals.right_digit+'</td>';
                    htmlss += '<td>'+vals.left_digit+'</td>';
                    htmlss += '<td>'+vals.bid_points+'</td>';
                    htmlss += '<td>'+vals.win_points+'</td>';
                    htmlss += '<td><a href="'+edit_url+'"class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></td></tr>';
                    $('#result_dataTable').prepend(htmlss);
                }); 
            }
            else{
                no_winner.style.display = "block";
                winner_list.style.display = "none";
            }
        }
    });
    return false;
 }
 
function clickresultdeclareButton(){
    playLoader();
    var gali_right_digit=document.getElementById('select_gali_right_digit').value;
    var game_id_gali=document.getElementById('game_id_gali').value;
    var from_date_new_declare=document.getElementById('from_date_new').value;
    var left_digit_result=document.getElementById('left_digit_result').value;
    
    
    var win_data = [];
    $.ajax({
        type:"post",
        url:"<?php echo SITE_URL; ?>Galidisawar/declare_ajax",
        // dataType: "JSON",
        data: 
        {  
            'gali_right_digit' :gali_right_digit,
            'game_id_gali' :game_id_gali,
            'from_date_new_declare' :from_date_new_declare,
            'left_digit_result' :left_digit_result,
        },
        cache:false,
        success: function (data) 
        {
            stopLoader();
            alert("Result Declared");
            var obj_declare = jQuery.parseJSON(data);
            if(obj_declare.length){
                var i = obj_declare.length;
                $.each(obj_declare, function(key_declare,val_declare) {
                    var user_url = '<?php echo SITE_URL;?>user_detail_list/user/'+val_declare.user_id;
                    var html_declare = '<tr>';
                    html_declare += '<td>'+(i--)+'</td>';
                    html_declare += '<td>'+val_declare.bidded_at+'</td>';
                    html_declare += '<td><a href="'+user_url+'">'+val_declare.mobile+'</a></td>';
                    html_declare += '<td><a href="'+user_url+'">'+val_declare.username+'</a></td>';
                    html_declare += '<td>'+val_declare.game_name+'</td>';
                    html_declare += '<td>'+val_declare.game_type+'</td>';
                    $('#declare_result').prepend(html_declare);
                }); 
            }
            else{
                
            }
            fetchResults();
        }
    });
    return false;
 }
 
function fetchResults(){
    playLoader();
    var from_date_new=document.getElementById('from_date_new').value;
    var no_result = document.getElementById('no_result');
    var resultData = document.getElementById('resultData');
    $('#declare_result').empty();
    
    var win_data = [];
    $.ajax({
        type:"post",
        url:"<?php echo SITE_URL; ?>Galidisawar/fetch_result",
        // dataType: "JSON",
        data: 
        {  
           'from_date_new' :from_date_new
        },
        cache:false,
        success: function (data) 
        {
            stopLoader();
            $('#declare_result').empty();
            var obj_declare = jQuery.parseJSON(data);
            if(obj_declare.length){
                resultData.style.display = "block";
                no_result.style.display = "none";
                var i = obj_declare.length;
                var dash = '-';
                $.each(obj_declare, function(key_declare,val_declare) {
                    var del_url = '<?php echo SITE_URL; ?>Galidisawar/change_res/'+val_declare.id;
                    var html_declare = '<tr class="text-center">';
                    var num_result = val_declare.right_digit+dash+val_declare.left_digit;
                    
                    var del_icon = '<a class="deleteConfirm bs-tooltip" data-delete-url="'+del_url+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>';
                    html_declare += '<td style="width: 2%">'+(i--)+'</td>';
                    html_declare += '<td>'+val_declare.game_name+'</td>';
                    html_declare += '<td>'+val_declare.time+'</td>';
                    html_declare += '<td>'+num_result+del_icon+'</td></tr>';
                    $('#declare_result').prepend(html_declare);
                }); 
            }
            else{
                resultData.style.display = "none";
                no_result.style.display = "block";
            }
        }
    });
    return false;
 }
 function playLoader(){
    document.getElementById("loader").style.display = "block";
 }
 function stopLoader(){
    document.getElementById("loader").style.display = "none";
 }
</script>