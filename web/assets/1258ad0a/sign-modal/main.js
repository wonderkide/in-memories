jQuery(document).ready(function($){
	var formModal = $('.cd-user-modal'),
		formLogin = formModal.find('#cd-login'),
		formSignup = formModal.find('#cd-signup'),
		formForgotPassword = formModal.find('#cd-reset-password'),
		formModalTab = $('.cd-switcher'),
		tabLogin = formModalTab.children('li').eq(0).children('a'),
		tabSignup = formModalTab.children('li').eq(1).children('a'),
		forgotPasswordLink = formLogin.find('.cd-form-bottom-message a'),
		backToLoginLink = formForgotPassword.find('.cd-form-bottom-message a'),
		mainNav = $('#nav-main-menu'),
                resetPW = $('#re-pwd-signin'),
                resetPWLoginPage = $('#re-pwd-login');

	//open modal
	mainNav.on('click', function(event){
		$(event.target).is(mainNav) && mainNav.children('ul').toggleClass('is-visible');
	});
        /*resetPW.on('click', function(event){
		$(event.target).is(resetPW) && resetPW.children('a').toggleClass('is-visible');
	});*/
        /*$(document).on('click', '#resetPWD', function(event) {
            alert();
		//$(event.target).is(mainNav) && mainNav.children('ul').toggleClass('is-visible');
	});*/

	//open sign-up form
	mainNav.on('click', '.cd-signup', signup_selected);
	//open login-form form
	mainNav.on('click', '.cd-signin', login_selected);
        //open login-form form
	resetPW.on('click', '.cd-signin', login_selected);
        //open login-form and go to resetPW form
	resetPWLoginPage.on('click', '.cd-signin', get_resetPW_selected);

	//close modal
	formModal.on('click', function(event){
		if( $(event.target).is(formModal) || $(event.target).is('.cd-close-form') ) {
			formModal.removeClass('is-visible');
		}	
	});
	//close modal when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		formModal.removeClass('is-visible');
	    }
    });

	//switch from a tab to another
	formModalTab.on('click', function(event) {
		event.preventDefault();
		( $(event.target).is( tabLogin ) ) ? login_selected() : signup_selected();
	});

	//hide or show password
	$('.hide-password').on('click', function(){
		var togglePass= $(this),
			passwordField = togglePass.prev('input');
		
		( 'password' == passwordField.attr('type') ) ? passwordField.attr('type', 'text') : passwordField.attr('type', 'password');
		( 'Hide' == togglePass.text() ) ? togglePass.text('Show') : togglePass.text('Hide');
		//focus and move cursor to the end of input field
		passwordField.putCursorAtEnd();
	});

	//show forgot-password form 
	forgotPasswordLink.on('click', function(event){
		event.preventDefault();
		forgot_password_selected();
	});

	//back to login from the forgot-password form
	backToLoginLink.on('click', function(event){
		event.preventDefault();
		login_selected();
	});

	function login_selected(){
		mainNav.children('ul').removeClass('is-visible');
		formModal.addClass('is-visible');
		formLogin.addClass('is-selected');
		formSignup.removeClass('is-selected');
		formForgotPassword.removeClass('is-selected');
		tabLogin.addClass('selected');
		tabSignup.removeClass('selected');
	}
        
        function get_resetPW_selected(){
		mainNav.children('ul').removeClass('is-visible');
		formModal.addClass('is-visible');
		formLogin.addClass('is-selected');
		formSignup.removeClass('is-selected');
		formForgotPassword.removeClass('is-selected');
		tabLogin.addClass('selected');
		tabSignup.removeClass('selected');
                forgot_password_selected();
	}

	function signup_selected(){
		mainNav.children('ul').removeClass('is-visible');
		formModal.addClass('is-visible');
		formLogin.removeClass('is-selected');
		formSignup.addClass('is-selected');
		formForgotPassword.removeClass('is-selected');
		tabLogin.removeClass('selected');
		tabSignup.addClass('selected');
	}

	function forgot_password_selected(){
		formLogin.removeClass('is-selected');
		formSignup.removeClass('is-selected');
		formForgotPassword.addClass('is-selected');
	}
        
        formLogin.find('#remember-me').on('click', function(event){
            var value = $(this).val();
            if(value ==1){
                $(this).val(0);
            }
            else{
                $(this).val(1);
            }
        });
        
        formSignup.find('#signup-agree').on('click', function(event){
            var value = $(this).val();
            if(value ==1){
                $(this).val(0);
            }
            else{
                $(this).val(1);
            }
        });
        
        formSignup.find('#img-captcha-refresh').on('click', function(event){
            event.preventDefault();
            $("img[id$='-captcha-image']").trigger('click');
        });
        

	//REMOVE THIS - it's just to show error messages 
	/*formLogin.find('input[type="submit"]').on('click', function(event){
		event.preventDefault();
		formLogin.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
	});
	formSignup.find('input[type="submit"]').on('click', function(event){
		event.preventDefault();
		formSignup.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
	});*/
    
        formLogin.find('#signin-username').on('change', function() {
            formLogin.find('#signin-username').removeClass('has-error').next('span').removeClass('is-visible');
        });
        formLogin.find('#signin-password').on('change', function() {
            formLogin.find('#signin-password').removeClass('has-error').next().next('span').removeClass('is-visible');
        });
        
        
        var img = formModal.find('#img-wait').attr('load');
    
        //submit form validate
        $(document).on('click', '#signin-submit-button', function(event) {
		event.preventDefault();
                
                formLogin.find('#signin-submit-block').text('');
                formLogin.find('#signin-submit-block').append('<img class="img-responsive center-block" src="'+img+'" />');
                
                formLogin.find('#signin-username').removeClass('has-error').next('span').removeClass('is-visible');
                formLogin.find('#signin-password').removeClass('has-error').next().next('span').removeClass('is-visible');

                var username = formLogin.find('#signin-username');
                var password = formLogin.find('#signin-password');
                var remember = formLogin.find('#remember-me');
                //console.log(username.val());
                $.ajax({
                    type: "POST",
                    url: "/site/check-login",
                    data:"u="+username.val()+'&p='+password.val()+'&r='+remember.val(),
                    success: function(r){

                            if(r == 1){
                                window.location = "/";
                            }
                            else if(r == 0){
                                alert('ไม่สามารถเชื่อมต่อกับ server ได้');
                            }
                            else{
                                array = JSON.parse(r);
                                if(typeof array["username"] !== 'undefined'){
                                    var usr_err = array['username'][0];
                                }
                                if(typeof array["password"] !== 'undefined'){
                                    var pw_err = array['password'][0];
                                }
                                if(pw_err){
                                    formLogin.find('#signin-password').addClass('has-error').next().next('span').text(pw_err).addClass('is-visible');
                                }
                                if(usr_err){
                                    formLogin.find('#signin-username').addClass('has-error').next('span').text(usr_err).addClass('is-visible');
                                }
                                formLogin.find('#signin-submit-block').text('');
                                formLogin.find('#signin-submit-block').append('<input id="signin-submit-button" class="full-width" type="submit" value="Login">');
                            }
                    }
                });
	});
        
        formSignup.find('#signup-username').on('change', function() {
            $(this).removeClass('has-error').next('span').removeClass('is-visible');
        });
        formSignup.find('#signup-email').on('change', function() {
            $(this).removeClass('has-error').next('span').removeClass('is-visible');
        });
        formSignup.find('#signup-password').on('change', function() {
            $(this).removeClass('has-error').next().next('span').removeClass('is-visible');
        });
        formSignup.find('#signup-re-password').on('change', function() {
            $(this).removeClass('has-error').next().next('span').removeClass('is-visible');
        });
        formSignup.find('#signup-captcha').on('change', function() {
            $(this).removeClass('has-error').next('span').removeClass('is-visible');
        });
        formSignup.find('#signup-agree').on('change', function() {
            $(this).removeClass('has-error').next().next('span').removeClass('is-visible');
        });
        
        $(document).on('click', '#signup-submit-button', function(event) {
            event.preventDefault();
                formSignup.find('#signup-submit-block').text('');
                formSignup.find('#signup-submit-block').append('<img class="img-responsive center-block" src="'+img+'" />');
                var username = formSignup.find('#signup-username');
                var email = formSignup.find('#signup-email');
                var password = formSignup.find('#signup-password');
                var repassword = formSignup.find('#signup-re-password');
                var verification = formSignup.find('#signup-captcha');
                var agree = formSignup.find('#signup-agree');
		
                $.ajax({
                    type: "POST",
                    url: "/site/check-signup",
                    data:"username="+username.val()+'&email='+email.val()+'&password='+password.val()+'&repassword='+repassword.val()+'&verification='+verification.val()+'&agree='+agree.val(),
                    success: function(r){

                            if(r == 1){
                                //window.location = "/";
                                formSignup.text('');
                                formSignup.append('<div class="alert-block-complete"><div class="alert alert-success" role="alert">Your registration has been successfully completed!</div><p class="text-center"><a id="signin-after-regist" href="#0">Sign in</a></p></div>');
                            }
                            else if(r == 0){
                                alert('ไม่สามารถเชื่อมต่อกับ server ได้');
                            }
                            else{
                                //console.log(JSON.parse(r));
                                array = JSON.parse(r);
                                //console.log(typeof array["username"] !== 'undefined');
                                if(typeof array["username"] !== 'undefined'){
                                    var usr_err = array['username'][0];
                                }
                                if(typeof array["email"] !== 'undefined'){
                                    var email_err = array['email'][0];
                                }
                                if(typeof array["password"] !== 'undefined'){
                                    var pw_err = array['password'][0];
                                }
                                if(typeof array["re_password"] !== 'undefined'){
                                    var re_pw_err = array['re_password'][0];
                                }
                                if(typeof array["verifyCode"] !== 'undefined'){
                                    var veri_err = array['verifyCode'][0];
                                }
                                if(typeof array["agree_rule"] !== 'undefined'){
                                    var agree_err = array['agree_rule'][0];
                                }
                                //console.log(usr_err);
                                //console.log(pw_err);
                                if(usr_err){
                                    formSignup.find('#signup-username').addClass('has-error').next('span').text(usr_err).addClass('is-visible');
                                }
                                if(email_err){
                                    formSignup.find('#signup-email').addClass('has-error').next('span').text(email_err).addClass('is-visible');
                                }
                                if(pw_err){
                                    formSignup.find('#signup-password').addClass('has-error').next().next('span').text(pw_err).addClass('is-visible');
                                }
                                if(re_pw_err){
                                    formSignup.find('#signup-re-password').addClass('has-error').next().next('span').text(re_pw_err).addClass('is-visible');
                                }
                                if(veri_err){
                                    formSignup.find('#signup-captcha').addClass('has-error').next('span').text(veri_err).addClass('is-visible');
                                }
                                if(agree_err){
                                    formSignup.find('#signup-agree').addClass('has-error').next().next('span').text(agree_err).addClass('is-visible');
                                }
                                formSignup.find('#signup-submit-block').text('');
                                formSignup.find('#signup-submit-block').append('<input id="signup-submit-button" class="full-width has-padding" type="submit" value="Create account">');
                            }
                    }
                });
        });
	$(document).on('click', '#signin-after-regist', function(event) {
            login_selected();
        });
        
        
        $(document).on('click', '#reset-pw-button', function(event) {
		event.preventDefault();
                formForgotPassword.find('#resetpw-submit-block').text('');
                formForgotPassword.find('#resetpw-submit-block').append('<img class="img-responsive center-block" src="'+img+'" />');
                
                formForgotPassword.find('#reset-password').removeClass('has-error').next('span').removeClass('is-visible');

                var data = formForgotPassword.find('#reset-password');

                $.ajax({
                    type: "POST",
                    url: "/site/reset-pw",
                    data:"data="+data.val(),
                    success: function(r){

                            if(r == 1){
                                formForgotPassword.text('');
                                formForgotPassword.append('<div class="alert-block-complete"><div class="alert alert-success" role="alert">Email has been sent!</div></div>');
                            }
                            else if(r == 0){
                                alert('ไม่สามารถเชื่อมต่อกับ server ได้');
                            }
                            else{
                                array = JSON.parse(r);
                                if(typeof array["username"] !== 'undefined'){
                                    var usr_err = array['username'][0];
                                }
                                if(usr_err){
                                    formForgotPassword.find('#reset-password').addClass('has-error').next('span').text(usr_err).addClass('is-visible');
                                }
                                formForgotPassword.find('#resetpw-submit-block').text('');
                                formForgotPassword.find('#resetpw-submit-block').append('<input id="reset-pw-button" class="full-width has-padding" type="submit" value="Reset password">');
                            }
                    }
                });
	});
        

	//IE9 placeholder fallback
	//credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
	if(!Modernizr.input.placeholder){
		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
		  	}
		}).blur(function() {
		 	var input = $(this);
		  	if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.val(input.attr('placeholder'));
		  	}
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
		  	$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
			 		input.val('');
				}
		  	})
		});
	}

});


//credits http://css-tricks.com/snippets/jquery/move-cursor-to-end-of-textarea-or-input/
jQuery.fn.putCursorAtEnd = function() {
	return this.each(function() {
    	// If this function exists...
    	if (this.setSelectionRange) {
      		// ... then use it (Doesn't work in IE)
      		// Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
      		var len = $(this).val().length * 2;
      		this.focus();
      		this.setSelectionRange(len, len);
    	} else {
    		// ... otherwise replace the contents with itself
    		// (Doesn't work in Google Chrome)
      		$(this).val($(this).val());
    	}
	});
};