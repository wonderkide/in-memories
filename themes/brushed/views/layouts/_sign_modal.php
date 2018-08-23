<?php
$this->registerCssFile(Yii::$app->assetManager->getPublishedUrl('@WDAsset')."/sign-modal/style.css", [
    'depends' => ['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset'],
]);
$this->registerCssFile(Yii::$app->assetManager->getPublishedUrl('@WDAsset')."/sign-modal/reset.css", [
    'depends' => ['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset'],
]);
$this->registerJsFile(Yii::$app->assetManager->getPublishedUrl('@WDAsset').'/sign-modal/modernizr.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->assetManager->getPublishedUrl('@WDAsset').'/sign-modal/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

use yii\captcha\Captcha;
use app\components\widgets\rules;
?>
<style>
    .fb-login-button span{
        /*width: 200px !important;*/
    }
    .fb-login-button iframe{
        /*width: 100px !important;*/
    }
</style>
<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<ul class="cd-switcher">
				<li><a href="#0">Sign in</a></li>
				<li><a href="#0">Sign up</a></li>
			</ul>

			<div id="cd-login"> <!-- log in form -->
				<form id="singin-form" class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-username" for="signin-username">Username</label>
						<input class="full-width has-padding has-border" id="signin-username" type="username" placeholder="Username">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signin-password">Password</label>
						<input class="full-width has-padding has-border" id="signin-password" type="password"  placeholder="Password">
						<a href="#0" class="hide-password">Show</a>
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset remember">
						<input type="checkbox" id="remember-me" value="1" checked>
						<label for="remember-me">Remember me</label>
					</p>

					<p class="fieldset" id="signin-submit-block" load="<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset') . "/sign-modal/img/please-wait.gif" ?>">
						<input id="signin-submit-button" class="full-width" type="submit" value="Login">
					</p>
                                        <div class="fieldset text-center">
                                            <?php Yii::$app->facebook->loginBTN(); ?>
                                        </div>
				</form>
				
				<p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-login -->

			<div id="cd-signup"> <!-- sign up form -->
				<form id="signup-form" class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-username">Username</label>
						<input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="Username">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-email" for="signup-email">E-mail</label>
						<input class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">Password</label>
						<input class="full-width has-padding has-border" id="signup-password" type="password"  placeholder="Password">
						<a href="#0" class="hide-password">Show</a>
						<span class="cd-error-message">Error message here!</span>
					</p>
                                        
                                        <p class="fieldset">
						<label class="image-replace cd-re-password" for="signup-password">Re Password</label>
						<input class="full-width has-padding has-border" id="signup-re-password" type="password"  placeholder="Re-Password">
						<a href="#0" class="hide-password">Show</a>
						<span class="cd-error-message">Error message here!</span>
					</p>
                                        
                                        <p class="fieldset">
                                            <?php echo Captcha::widget([
                                                'name' => 'captcha',
                                                'id' => 'signup-captcha',
                                                'template' => '<div class="row">
                                                    <div class="col-xs-3 no-padding-right">
                                                        {image}
                                                    </div>
                                                    <div class="col-xs-1 no-padding">
                                                        <img id="img-captcha-refresh" title="Refresh image" src="'.Yii::$app->assetManager->getPublishedUrl('@WDAsset') . "/sign-modal/img/refresh.png".'" />
                                                    </div>
                                                    <div class="col-xs-8">
                                                        <label class="image-replace cd-captcha" for="signup-captcha">Verification</label>
                                                        <input class="full-width has-padding has-border" id="signup-captcha" type="text" placeholder="Verification">
                                                        <span class="cd-error-message">Error message here!</span>
                                                    </div></div>',
                                            ]); ?>
						<!--<label class="image-replace cd-re-password" for="signup-password">Re Password</label>
						<input class="full-width has-padding has-border" id="signup-re-password" type="text"  placeholder="Re-Password">
						<a href="#0" class="hide-password">Hide</a>-->
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="signup-agree" value="0">
						<label for="accept-terms">I agree to the <a class="rules-modal-button" href="#0">Terms</a></label>
                                                <span class="cd-error-message">Error message here!</span>
					</p>

                                        <p class="fieldset" id="signup-submit-block" load="<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset') . "/sign-modal/img/please-wait.gif" ?>">
						<input id="signup-submit-button" class="full-width has-padding" type="submit" value="Create account">
					</p>
				</form>

				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-signup -->

			<div id="cd-reset-password"> <!-- reset password form -->
				<p class="cd-form-message">Lost your password? Please enter your username or email address. You will receive a link to create a new password.</p>

				<form id="resetpw" class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-email" for="reset-email">Username or E-mail</label>
						<input class="full-width has-padding has-border" id="reset-password" type="text" placeholder="Username or E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset" id="resetpw-submit-block">
						<input id="reset-pw-button" class="full-width has-padding" type="submit" value="Reset password">
					</p>
				</form>

				<p class="cd-form-bottom-message"><a href="#0">Back to log-in</a></p>
			</div> <!-- cd-reset-password -->
			<a href="#0" class="cd-close-form">Close</a>
		</div> <!-- cd-user-modal-container -->
                <div id="img-wait" class="hidden" load="<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset') . "/sign-modal/img/please-wait.gif" ?>"></div>
	</div> <!-- cd-user-modal -->
<?php echo rules::widget([]); ?>