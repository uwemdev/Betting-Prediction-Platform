<?php

require( 'inc/db.php' );
require( 'inc/functions.php' );

if(isset($_COOKIE['rt']) && !isset($_SESSION['loggedin'])){
    $token              =   secure($_COOKIE['rt']);

    $checkTokenQuery    =   $db->prepare("SELECT `id`,`username`,`isAdmin`,`isVip` FROM ve_users WHERE login_token = :token");
    $checkTokenQuery->execute(array(
        ":token"        =>  $token
    ));
    if($checkTokenQuery->rowCount() === 1){
        $checkTokenRow  =   $checkTokenQuery->fetch(PDO::FETCH_ASSOC);

        $_SESSION['username']   =   $checkTokenRow['username'];
        $_SESSION['uid']        =   $checkTokenRow['id'];
        $_SESSION['loggedin']   =   true;

        if($checkTokenRow['isAdmin'] == 2){
            $_SESSION['isAdmin']    =   true;
        }
        if($checkTokenRow['isVip'] == 2){
            $_SESSION['isVip']    =   true;
        }
    }
}

if(isset($_SESSION['loggedin'])){
    $userQuery          =   $db->prepare("SELECT * FROM ve_users WHERE id = :id");
    $userQuery->execute(array(
        ":id"           =>  $_SESSION['uid']
    ));
    $userRow            =   $userQuery->fetch(PDO::FETCH_ASSOC);
}
$slides             =  json_decode($settings['slides']);

if(!empty($slides)){
    foreach($slides as $sk => $sv){
        $slideQuery     =   $db->prepare("SELECT `title`,`media_type`,`slug_url`,`id`,`cote` FROM ve_media WHERE id = :id");
        $slideQuery->execute(array(
            ":id"       =>  $sv->id
        ));
        $slideRow       =   $slideQuery->fetch(PDO::FETCH_ASSOC);
        $slides[$sk]->title   =   $slideRow['title'];

        if($slideRow['media_type'] == 1){
            $type                   =   'bet';
        }

        $slides[$sk]->url           =   $type . '/' . $slideRow['slug_url'] . '-' . $slideRow['id'];
    }
}


include( 'inc/header.inc.php' );

?>

    <script>
        var countries   =   <?php echo json_encode($countryArray); ?>;
        var settings    =   <?php echo json_encode($settings); ?>;
        var cats        =   <?php echo json_encode($catsRow); ?>;
        var slides      =   <?php echo json_encode($slides); ?>;

        window.fbAsyncInit = function() {
            FB.init({
                appId      : settings.fb_app_key,
                xfbml      : true,
                version    : 'v2.3'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_EN/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <div id="fb-root"></div>
<div class="ui-view-container">
        <div ui-view></div>
    </div>

<?php

include( 'inc/footer.inc.php' );

?>