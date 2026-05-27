var base_url= $("#base_url").val();
var oTable = $('#myTable');

var valid = {
			 

			ajaxError:function(jqXHR,exception) {
				var msg = '';
				if (jqXHR.status === 0) {
					msg = 'Not connect.\n Verify Network.';
				} else if (jqXHR.status == 404) {
					msg = 'Requested page not found. [404]';
				} else if (jqXHR.status == 500) {
					msg = 'Internal Server Error [500].';
				} else if (exception === 'parsererror') {
					msg = 'Requested JSON parse failed.';
				} else if (exception === 'timeout') {
					msg = 'Time out error.';
				} else if (exception === 'abort') {
					msg = 'Ajax request aborted.';
				} else {
					msg = 'Uncaught Error.\n' + jqXHR.responseText;
				}
				return msg;
			},
			validPassword:function(inputtxt){
				var pass = /[!@#$%^&*()_+|*{}<>]/;
				return pass.test(inputtxt);
			},
			validAlphanumeric:function(inputtxt){
				var letter = /^.*(?=.{6,20})(?=.*\d)(?=.*[a-zA-Z]).*$/; 
				return letter.test(inputtxt);
			},
			phonenumber:function(inputtxt) {
				var phoneno = /^\d{10}$/;  
				return phoneno.test(inputtxt);
			},
			validPhone:function(inputtxt) {
				var phoneno = /^[0-9]\d{2,4}-\d{6,8}$/;  
				return phoneno.test(inputtxt);
			},
			validURL:function(inputtxt) {
				var re = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
				return re.test(inputtxt);
			},
			validateEmail:function(email) {
				var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(email);
			},
			validFBurl:function(enteredURL) {
				var FBurl = /^(http|https)\:\/\/www.facebook.com\/.*/i;
				return FBurl.test(enteredURL);
			},
			validTwitterurl:function(enteredURL) {
				var twitterURL = /^(http|https)\:\/\/twitter.com\/.*/i;
				return twitterURL.test(enteredURL);
			},
			validYoutubeURL:function(enteredURL) {
				var youtubeURL = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
				return youtubeURL.test(enteredURL);
			},
			validGPlusURL:function(enteredURL) {
				var gPlusURL = /\+[^/]+|\d{21}/;
				return gPlusURL.test(enteredURL);
			},
			validInstagramURL:function(enteredURL) {
				var instagramURL = /(?:(?:http|https):\/\/)?(?:www.)?(?:instagram.com|instagr.am)\/([A-Za-z0-9-_\.]+)/im;
				return instagramURL.test(enteredURL);
			},
			validateExtension:function(val,type) {
				if(type==1)
					var re = /(\.jpeg|\.jpg|\.png)$/i;
				else if(type==2)
					var re = /(\.jpeg|\.jpg|\.png\.pdf|\.doc|\.xml|\.docx|\.PDF|\.DOC|\.XML|\.DOCX|\.xls|\.xlsx)$/i;
				else if(type==3)
					var re = /(\.jpeg|\.jpg|\.pdf|\.png|\.docx|\.PDF|\.DOC|\.DOCX)$/i;
				return re.test(val)
			},
			snackbar:function(msg) {
				$("#snackbar").html(msg).fadeIn('slow').delay(3000).fadeOut('slow');
			},
			snackbar_error:function(msg) {
				$("#snackbar-error").html(msg).fadeIn('slow').delay(3000).fadeOut('slow');
			},
			snackbar_success:function(msg) {
				$("#snackbar-success").html(msg).fadeIn('slow').delay(3000).fadeOut('slow');
			},
			snackbar2:function(msg) {
				 $("#snackbar").html(msg).fadeIn('slow');
			},
			error:function(msg) {
				return "<p class='alert alert-danger'><strong>Error: </strong>"+msg+"</p>";
			},
			success:function(msg) {
				return "<p class='alert alert-success'>"+msg+"</p>";
			},
			info:function(msg) {
				return "<p class='alert alert-info'>"+msg+"</p>";
			}
	};
	
jQuery(function($) {
	"use strict";
	
	
	$('.link_scroll').click(function() {	
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {		
			var target = $(this.hash);		
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');		
			if (target.length) {			
				$('html, body').animate({		
					scrollTop: target.offset().top - 70			
				}, 1500);			
				return false;	
			}		
		}	
	});
	
	$(document).on('click', '.copyData', function(e){
		var copyText = $(this).data('text');
		var $temp = $("<input>");
		  $("body").append($temp);
		  $temp.val(copyText).select();
		  document.execCommand("copy");
		  $temp.remove();
		  valid.snackbar('Copied to Clipboard');
	});
	
	$(document).on('keypress', '.mobile-valid', function(e){
		var $this = $(this);
		var regex = new RegExp("^[0-9\b]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		// for 10 digit number only
		if ($this.val().length > 9) {
			e.preventDefault();
			return false;
		}
		if (e.charCode < 54 && e.charCode > 47) {
			if ($this.val().length == 0) {
				e.preventDefault();
				return false;
			} else {
				return true;
			}
		}
		if (regex.test(str)) {
			return true;
		}
		e.preventDefault();
		return false;
	});
	
	$(".member_id_check").keydown(function(e) {
    // Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		  // Allow: Ctrl+A,Ctrl+C,Ctrl+V, Command+A
		  ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
		  // Allow: home, end, left, right, down, up
		  (e.keyCode >= 35 && e.keyCode <= 40)) {
		  // let it happen, don't do anything
		  return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		  e.preventDefault();
		}
	  });
	  
	  
	  $(document).on('keypress', '.name-valid', function(e){
		if (event.charCode!=0) {
			var regex = new RegExp("^[a-zA-Z ]*$");
			var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			if (!regex.test(key)) {
				event.preventDefault();
				return false;
			}
		}
	});
	
	$("#contact_form").submit(function(e) 
	{ 
		var username = $("#contact_name").val();
		var mobile_no = $("#mobile_no").val();
		var email = $("#email").val();
		var message = $("#message").val();
		var image_code = $("#image_code").val();
		if(username == ''){
			$("#errormsg").html(valid.error('Please enter your name')).fadeIn('slow').delay(2500).fadeOut('slow');
		}else if(mobile_no == ''){
			$("#errormsg").html(valid.error('Please enter your mobile number')).fadeIn('slow').delay(2500).fadeOut('slow');
		}else if(email == ''){
			$("#errormsg").html(valid.error('Please enter your email')).fadeIn('slow').delay(2500).fadeOut('slow');
		}else if(message == ''){
			$("#errormsg").html(valid.error('Please enter your message')).fadeIn('slow').delay(2500).fadeOut('slow');
		}else if(image_code == ""){
			$("#errormsg").html(valid.error('Please enter captcha code')).fadeIn('slow').delay(2500).fadeOut('slow');
		}else{
		$("#submitBtn").attr("disabled",true);	   
		var changeBtn = $("#submitBtn").html();
		$("#submitBtn").html("Sending..");
			$.ajax({ 
				url: base_url + 'submit-user-query',
				type: 'POST',
				data: new FormData( this ),
				processData: false,
				contentType: false,
				dataType: "json",
				success: function (data)
				{	
					if(data.status == "success") 
					{
						$('#errormsg').html(data.msg).fadeIn('slow').delay(2000).fadeOut('slow');
						$('#contact_form')[0].reset(); 
					}else{
						$("#errormsg").html(data.msg).fadeIn('slow').delay(2500).fadeOut('slow');
						refreshCaptcha();
					}
					$("#submitBtn").attr("disabled",false);
					$("#submitBtn").html(changeBtn);
				},
				error: function (jqXHR, exception) {
					var msg = valid.ajaxError(jqXHR,exception);
					$("#errormsg").html(valid.error(msg)).fadeIn('slow').delay(5000).fadeOut('slow');
					$("#submitBtn").attr("disabled",false);
					$("#submitBtn").html(changeBtn);
				}
			});
		}
        e.preventDefault();	
    }); 
	
	
});	

function refreshCaptcha(){
	var img = document.images['captchaimg3']; 
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
