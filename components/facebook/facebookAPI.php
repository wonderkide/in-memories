<?php
namespace app\components\facebook;

use Yii;
use yii\base\Component;
use Facebook\Facebook;

class facebookAPI extends Component {
    
    public $appID = "860750877421572";
    public $appSecret = "aca79b3feb9af7d7c35ac5a3a045cca3";
    public $pageID = "151970652217442";
    public $pageURL = "https://www.facebook.com/In-memories-151970652217442";
    public $page_box_width = null;
    public $page_box_height = null;
    public $page_box_small_header = false;
    public $page_box_hide_cover = false;

    public function init() {
        parent::init();
    }

    public function loadScript() {
        echo    '<script>
                window.fbAsyncInit = function() {
                FB.init({
                  appId            : "'.$this->appID.'",
                  autoLogAppEvents : true,
                  cookie           : true,
                  xfbml            : true,
                  version          : "v2.11"
                });
                };
                function statusChangeCallback(response) {
                    console.log(\'statusChangeCallback\');
                    console.log(response);
                    if (response.status === "connected") {
                        window.location.replace("/site/fblogin");
                    } 
                }
                function checkLoginState() {
                    FB.getLoginStatus(function(response) {
                      statusChangeCallback(response);
                    });        
                }

                (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
                }(document, "script", "facebook-jssdk"));
                </script>';
    }
    
    public function loadChatBox() {
        echo '<div class="fb-customerchat" page_id="'.$this->pageID.'"></div>';
    }
    
    public function loadPageBox(){
        if($this->page_box_small_header){
            $header = 'true';
        }
        else{
            $header = 'false';
        }
        if($this->page_box_hide_cover){
            $hide = 'true';
        }
        else{
            $hide = 'false';
        }
        echo '<div class="fb-page" data-href="'.$this->pageURL.'" data-tabs="timeline" data-width="'.$this->page_box_width .'" data-height="'.$this->page_box_height .'" data-small-header="'.$header.'" data-adapt-container-width="true" data-hide-cover="'.$hide.'" data-show-facepile="true"><blockquote cite="'.$this->pageURL.'" class="fb-xfbml-parse-ignore"><a href="'.$this->pageURL.'"></a></blockquote></div>';
    }
    
    public function loginBTN() {
        //echo '<fb:login-button  style="" data-width="5000" data-size="large" scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>';
        echo '<div style="max-width:100%;" onlogin="checkLoginState();" class="fb-login-button" data-width="200" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>';
    }
    
    
    public function login(){
        $fb = new Facebook([
            'app_id' => $this->appID,
            'app_secret' => $this->appSecret,
            'default_graph_version' => 'v2.11',
            ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(Yii::$app->seo->getUrl('site/fblogin'), $permissions);

        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
    }
    
    public function fb_user_data() {
        
        //require('../../vendor/facebook/graph-sdk/src/Facebook/autoload.php');
        //require __DIR__ . '/../../vendor/facebook/graph-sdk/src/Facebook/autoload.php';

        //global $fb_app_id,$fb_secret,$scripturl;
        
        $scripturl = '/site/error';

        $fb = new \Facebook\Facebook([
                'app_id' => $this->appID,
                'app_secret' => $this->appSecret,
                'default_graph_version' => 'v2.11',
                ]);


        $jsHelper = $fb->getJavaScriptHelper();
        // @TODO This is going away soon
        $facebookClient = $fb->getClient();

        try {
            $accessToken = $jsHelper->getAccessToken($facebookClient);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            //dfb_flash('dfb_fb_error','มีบางอย่างผิดพลาด กรุณาลองใหม่ภายหลัง');
            header('Location: ' . $scripturl);
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            //dfb_flash('dfb_fb_error','มีบางอย่างผิดพลาด กรุณาลองใหม่ภายหลัง');
            header('Location: ' . $scripturl);
            exit;
        }

        if (isset($accessToken)) {
            // Logged in.
            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get('/me?fields=id,name,email', $accessToken);
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                //dfb_flash('dfb_fb_error','มีบางอย่างผิดพลาด กรุณาลองใหม่ภายหลัง');
                header('Location: ' . $scripturl);
                exit;
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                //dfb_flash('dfb_fb_error','มีบางอย่างผิดพลาด กรุณาลองใหม่ภายหลัง');
                header('Location: ' . $scripturl);
                exit;
            }
        } else {
            // Unable to read JavaScript SDK cookie
            //dfb_flash('dfb_fb_error','มีบางอย่างผิดพลาด กรุณาลองใหม่ภายหลัง');
            header('Location: ' . $scripturl);
            exit;
        }




        // Returns a `Facebook\GraphNodes\GraphUser` collection
        return $user = $response->getGraphUser();
    }

}
