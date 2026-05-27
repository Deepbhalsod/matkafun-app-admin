<?php
session_start();
/** Show Alert Message */

function show_alert()
{
	if (is($_SESSION['FlashStatus'])): ?>
		<div class="my-4">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
			<div class="alert alert-<?php $_SESSION['FlashStatus'] == 'Success' and print('success') or print('warning'); ?> alert-dismissible fade show"
				role="alert">
				<strong>
					<?php is($_SESSION['FlashTitle'], 'showCapital'); ?>,
				</strong>
				<?php is($_SESSION['FlashData'], 'showCapital'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php endif;

	unset($_SESSION['FlashStatus']);
	unset($_SESSION['FlashTitle']);
	unset($_SESSION['FlashData']);
}

/** Show Message
 * @return void */
function show_message()
{
	if (isset($_SESSION['FlashStatus']) and !empty($_SESSION['FlashStatus'])): ?>

		<div class="alert bg-light alert-<?php $_SESSION['FlashStatus'] == 'Success' and print('success') or print('danger'); ?> alert-dismissible w-lg-25 w-md-50  fade show position-fixed"
			style="top:8%; right:1%; z-index: 9999;" role="alert">
				<svg xmlns="http://www.w3.org/2000/svg" class="succ" width="20" height="20" viewBox="0 0 20 20" fill="none">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM14.0303 6.96967C14.3232 7.26256 14.3232 7.73744 14.0303 8.03033L9.03033 13.0303C8.73744 13.3232 8.26256 13.3232 7.96967 13.0303L5.96967 11.0303C5.67678 10.7374 5.67678 10.2626 5.96967 9.96967C6.26256 9.67678 6.73744 9.67678 7.03033 9.96967L8.5 11.4393L10.7348 9.2045L12.9697 6.96967C13.2626 6.67678 13.7374 6.67678 14.0303 6.96967Z" fill="#62e97b"/>
				</svg>

				<svg xmlns="http://www.w3.org/2000/svg" class="wrong" width="20" height="20" viewBox="0 0 20 20" fill="none">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM6.96963 6.96965C7.26252 6.67676 7.73739 6.67676 8.03029 6.96965L9.99997 8.93933L11.9696 6.96967C12.2625 6.67678 12.7374 6.67678 13.0303 6.96967C13.3232 7.26256 13.3232 7.73744 13.0303 8.03033L11.0606 9.99999L13.0303 11.9696C13.3232 12.2625 13.3232 12.7374 13.0303 13.0303C12.7374 13.3232 12.2625 13.3232 11.9696 13.0303L9.99997 11.0607L8.03031 13.0303C7.73742 13.3232 7.26254 13.3232 6.96965 13.0303C6.67676 12.7374 6.67676 12.2625 6.96965 11.9697L8.93931 9.99999L6.96963 8.03031C6.67673 7.73742 6.67673 7.26254 6.96963 6.96965Z" fill="#fd355a"/>
				</svg>

			<?php if (isset($_SESSION['FlashTitle']) and !empty($_SESSION['FlashTitle'])): ?>
					<h5 class="text-white mb-0">
						<?= $_SESSION['FlashTitle']; ?>
					</h5>
			<?php endif; ?>
			<button type="button" style="border:none; box-shadow:none; outline:none;" class="close_" data-dismiss="alert"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="flashScreen"></div>
		<script>
			document.querySelector('.flashScreen').setAttribute('style', "position: absolute;top: 0;bottom: 0;left: 0;background: #fff;right: 0;z-index: 9998;");
			// 			var audio = new Audio('<?php echo SITE_URL; ?>assets/audio/credulous.ogg');
			// 			audio.play();
			setTimeout(() => {
				document.querySelector('.flashScreen').setAttribute('style', '');
			}, 800);
		</script>
	<?php endif; ?>
	<?php if (validation_errors()): ?>
		<div class="alert bg-light alert-danger alert-dismissible w-lg-25 w-md-50 fade show position-fixed"
			style="top:8%; right:1%; z-index: 9999;" role="alert">
			
				<h5 class="text-white mb-0">Unsuccess</h5>
			
			<!-- <div class="alertMessage card-body ">
				<p class="text-dark font-weight-bold">
					<?= validation_errors() ?>
				</p>
			</div> -->
			<button type="button" style="border:none; box-shadow:none; outline:none;" class="close" data-dismiss="alert"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="flashScreen"></div>
		<script>
			document.querySelector('.flashScreen').setAttribute('style', "position: absolute;top: 0;bottom: 0;left: 0;background: #fff;right: 0;z-index: 9998;");
			// 			var audio = new Audio('<?php echo SITE_URL; ?>assets/audio/credulous.ogg');
			// audio.play();
			setTimeout(() => {
				document.querySelector('.flashScreen').setAttribute('style', '');
			}, 800);
		</script>


	<?php endif;
	unset($_SESSION['FlashStatus']);
	unset($_SESSION['FlashTitle']);
	unset($_SESSION['FlashData']);
}

/** `Flash Message`
 *
 *
 * Set Flash Message & Redirect
 *
 * @param string        $location Controller Name without Site_url
 * @param bool          $conditions Check Conditions
 * @param string        $type Success or Unsuccess
 * @param string        $title Title Of Flash Message
 * @param string|null   $msg Optional Detailed Message */
function flash_message($location, $conditions, $type, $title, $msg = null)
{
	$ci = &get_instance();
	if (strtolower($type) == "success") {

		$conditions and $ci->session->set_flashdata('FlashStatus', "Success");
		$conditions and $ci->session->set_flashdata('FlashTitle', $title);
		$conditions and $ci->session->set_flashdata('FlashData', $msg);
		$conditions and redirect(SITE_URL . $location);
	} else {
		$conditions or $ci->session->set_flashdata('FlashStatus', "Unsuccess");
		$conditions or $ci->session->set_flashdata('FlashTitle', $title);
		$conditions or $ci->session->set_flashdata('FlashData', $msg);
		$conditions or redirect(SITE_URL . $location);
	}
}

/* End of file flash.php */