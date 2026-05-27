<?php breadcrumb_start('Result', 'list/result', 'result_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">
			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-6">
							<label>Date</label>
							<input type="text" class="form-control" id="title" name="date" placeholder="Date" value="<?php echo date("Y-m-d"); ?>" readonly>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group mb-6">
							<label>Game Name</label>
							<select class="selectpicker form-control" data-live-search="true" name="game_id" title="Select Game" id="slect_job_cat" value="">
								<option value="All">All</option>
								<?php foreach ($games as $value) :
								
								?>
									<option value="<?php echo($value['id']); ?>">
										<?php is($value['name'], 'showCapital'); ?>(<?php echo $value['open_time']; ?>-<?php echo $value['close_time']; ?>)</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group mb-6">
							<label>Session</label>
							<select class="selectpicker form-control"  name="session" title="Select Session" id="slect_job_Sessiont" value="">
								<option value="Open">Open</option>
								<option value="Close">Close</option>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group mb-6">
							<label>Pana</label>
							<select class="selectpicker form-control" data-live-search="true"  name="pana" title="Select Pana" id="slect_pana" value="">

								<?php foreach ($number as $val) :
									$category_idss = $_POST['pana'] ?? '';
								?>
									<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group mb-6">
							<label>Result</label>
							<input type="text" class="form-control" id="result_fmod" name="result" placeholder="Result" value="" readonly>
						</div>
					</div>
				</div>
				<div class="row">
					
			    	<div class="col-md-2">
        				
        				<button type="submit" name="add_show_win" value="add_show_win" class="ml-xl-4 btn btn-primary mt-4">Show Winner List</button>
        				
			    	</div>
			    	<div class="col-md-2">
            				
            			<button type="submit" name="addresult" value="addresult" class="ml-xl-4 btn btn-primary mt-4">Declare</button>
            				
			    	</div>
				</div>
				
				
			</form>
			
		</div>
	</div>
</div>
<?php if(!empty($chk)):?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">
			<form method="post">
				<button class="primary">Winner List</button>
				<div class="table-responsive mb-4 mt-4">
					<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
						<thead>
							<tr class="text-center">
								<th style="width: 2%">#</th>
								<th>User Name</th>
								<th>User Phone No</th>
								<th>Game Name</th>
								<th>Game Type</th>
								<th>Open Panna</th>
								<th>Open Digit</th>
								<th>Close Panna</th>
								<th>Close Digit</th>
								<th>Bid Points</th>
							</tr>
						</thead>
						<tbody class="text-center">
							<?php $i = 1;
							

								foreach ($chk as $key => $value) :
							?>
									<tr>
										<td><?php echo $i++; ?>.</td>


										<td class="text-center">
											<?php if (empty($value['user_id'])) {
												echo "N/A";
											} else {
												$return = get_signle_data_from('users', ['id' => $value['user_id']]);
												
												if ($return) {
												    $return1 = $return->username;
												    if($return1){
												        echo ($return1);
												    }else {
													    echo "N/A";
												    }
												}else {
													    echo "N/A";
												}
											} ?>
										</td>

										<td class="text-center">
											<?php if (empty($value['user_id'])) {
												echo "N/A";
											} else {
												$mob = get_signle_data_from('users', ['id' => $value['user_id']]);
												
												if($mob){
												    $phone1 = $mob->mobile;
    												if ($phone1) {
    													echo ($phone1);
    												} else {
    													echo "N/A";
    												}
												}else {
    												echo "N/A";
    											}
											} ?>
										</td>
										
										<td class="text-center">
											<?php if (empty($value['game_id'])) {
												echo "N/A";
											} else {
												$gamee = get_signle_data_from('games', ['id' => $value['game_id']]);
												
												if($gamee){
												    $gamm = $gamee->name;
    												if ($gamm) {
    													echo ($gamm);
    												} else {
    													echo "N/A";
    												}
												}else {
    												echo "N/A";
    											}
											} ?>
										</td>
										
										<td class="text-center">
											<?php if ($value['game_type'] == "") {
												echo "NA";
											} else {
												echo $value['game_type'];
											} ?>
										</td>

										<td class="text-center">
											<?php if ($value['open_panna'] == "") {
												echo "NA";
											} else {
												echo $value['open_panna'];
											} ?>
										</td>
										
										<td class="text-center">
											<?php if ($value['open_digit'] == "") {
												echo "NA";
											} else {
												echo $value['open_digit'];
											} ?>
										</td>

										<td class="text-center">
											<?php if ($value['close_panna'] == "") {
												echo $close_pana = "NA";
											} else {
												echo $value['close_panna'];
											} ?>
										</td>
											
										<td class="text-center">
											<?php if ($value['close_digit'] == "") {
												echo "NA";
											} else {
												echo $value['close_digit'];
											} ?>
										</td>
										
										<td class="text-center">
											<?php if ($value['bid_points'] == "") {
												echo "NA";
											} else {
												echo $value['bid_points'];
											} ?>
										</td>
									</tr>
								<?php endforeach; ?>
							
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>