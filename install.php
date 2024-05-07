<?php
$m  =   "";

if(isset($_POST['dbhost'], $_POST['dbname'], $_POST['dbusername'], $_POST['dbpass'])){
    try {
        $db = new PDO('mysql:host=' . $_POST['dbhost'] . ';dbname=' . $_POST['dbname'], $_POST['dbusername'], $_POST['dbpass']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dbSQL   =   file_get_contents('db.sql.txt');
        $createSite =   $db->prepare($dbSQL);
        $createSite->execute();
        $createSite->closeCursor();


        if(empty($_POST['site_dir'])){
            $_POST['site_dir']  =   "/";
        }

        if(substr($_POST['site_dir'], -1) != "/"){
            $_POST['site_dir'] .= "/";
        }
		
        $domain             =   str_replace("http://", "", $_POST['site_domain']);
        $dir                =   str_replace("\\", "", dirname(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) . '/');
		$pub1 = '<img src="http://placehold.it/250x250">';
		$pub2 = '<img src="http://placehold.it/728x90">';
		$pub3 = '<img src="http://placehold.it/728x90">';
		$pub4 = '<img src="http://placehold.it/970x90">';

mysql_query("SET NAMES 'utf8'");
		
		$insertQuery    =   $db->prepare(
           "
		   INSERT INTO `ve_categories` (`id`, `name`, `pos`) VALUES (1, 'Football', 1),(2, 'Tennis', 2),(3, 'Basketball', 3),(4, 'Rugby', 4),(5, 'Handball', 5),(6, 'Volleyball', 6);
		   
		   INSERT INTO `ve_settings` (`id`, `site_name`, `site_title`, `site_desc`, `display_count`, `site_dir`, `max_media_img_size`, `isPreapproved`, `canCreatebet`, `facebook`, `twitter`, `youtube`, `user_registration`, `profile_img_size`, `site_domain`, `slides`, `sidebar_ad`, `footer_ad`, `footer_ad2`, `amount_vip`, `method_vip`, `mail_receive_payment_vip`) VALUES
(1, '" . $_POST['site_name'] . "', '" . $_POST['site_name'] . "', '" . $_POST['site_description'] . "', 100000, '" . $dir . "', 1, 1, 1, '" . $_POST['site_name'] . "', '" . $_POST['site_name'] . "', '" . $_POST['site_name'] . "', 1, NULL, '" . $domain . "', '".$pub1."', '".$pub2."', '".$pub3."', '".$pub4."', '10 EUROS', 'paypal', 'yourmail@mail.com');
			
           INSERT INTO `ve_users` (`id`, `username`, `pass`, `email`, `upl_dir`, `login_token`, `location`, `gender`, `about`, `profile_img`, `points`, `status`, `display_name`, `time_joined`, `isAdmin`, `isVip`) VALUES
(1, 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '" . $_POST['admin_mail'] . "', '/uploads/a/1/admin/', '1514935667', '" . $dir . "', 1, NULL, 'default-profile.png', 0, 1, '', 0, 2, 2);


            "
        );
        $insertQuery->execute();

        unlink("db.sql.txt");

		//CREER STATS.PHP
        $files   =   file_get_contents('app/views/stats_sample.php');
        $files   =   str_replace("RRHOST",trim($_POST["dbhost"]),$files);
        $files   =   str_replace("RRDBNAME",trim($_POST["dbname"]),$files);
        $files   =   str_replace("RRUSER",trim($_POST["dbusername"]),$files);
        $files   =   str_replace("RRPASS",trim($_POST["dbpass"]),$files);
        $fhs     =   fopen('app/views/stats.php', 'w') or die("Open stats.php is impossible. Be sure that this file is on permission 777.");
        fwrite($fhs, $files);
        fclose($fhs);
		
		//CREER NEWS.PHP
        $filesev   =   file_get_contents('app/views/vip_sample.php');
        $filesev   =   str_replace("RRHOST",trim($_POST["dbhost"]),$filesev);
        $filesev   =   str_replace("RRDBNAME",trim($_POST["dbname"]),$filesev);
        $filesev   =   str_replace("RRUSER",trim($_POST["dbusername"]),$filesev);
        $filesev   =   str_replace("RRPASS",trim($_POST["dbpass"]),$filesev);
        $fhsev     =   fopen('app/views/vip.php', 'w') or die("Open vip.php is impossible. Be sure that this file is on permission 777.");
        fwrite($fhsev, $filesev);
        fclose($fhsev);
		
		//CREER NEWS.PHP
        $filese   =   file_get_contents('app/views/news_sample.php');
        $filese   =   str_replace("RRHOST",trim($_POST["dbhost"]),$filese);
        $filese   =   str_replace("RRDBNAME",trim($_POST["dbname"]),$filese);
        $filese   =   str_replace("RRUSER",trim($_POST["dbusername"]),$filese);
        $filese   =   str_replace("RRPASS",trim($_POST["dbpass"]),$filese);
        $fhse     =   fopen('app/views/news.php', 'w') or die("Open news.php is impossible. Be sure that this file is on permission 777.");
        fwrite($fhse, $filese);
        fclose($fhse);
		
        $filesea   =   file_get_contents('admin/news_sample.php');
        $filesea   =   str_replace("RRHOST",trim($_POST["dbhost"]),$filesea);
        $filesea   =   str_replace("RRDBNAME",trim($_POST["dbname"]),$filesea);
        $filesea   =   str_replace("RRUSER",trim($_POST["dbusername"]),$filesea);
        $filesea   =   str_replace("RRPASS",trim($_POST["dbpass"]),$filesea);
        $fhsea     =   fopen('admin/news.php', 'w') or die("Open news.php is impossible. Be sure that this file is on permission 777.");
        fwrite($fhsea, $filesea);
        fclose($fhsea);		

        $fileseae   =   file_get_contents('admin/users_sample.php');
        $fileseae   =   str_replace("RRHOST",trim($_POST["dbhost"]),$fileseae);
        $fileseae   =   str_replace("RRDBNAME",trim($_POST["dbname"]),$fileseae);
        $fileseae   =   str_replace("RRUSER",trim($_POST["dbusername"]),$fileseae);
        $fileseae   =   str_replace("RRPASS",trim($_POST["dbpass"]),$fileseae);
        $fhseae     =   fopen('admin/users.php', 'w') or die("Open users.php is impossible. Be sure that this file is on permission 777.");
        fwrite($fhseae, $fileseae);
        fclose($fhseae);		
				
        $file   =   file_get_contents('inc/db-sample.php');
        $file   =   str_replace("RRHOST",trim($_POST["dbhost"]),$file);
        $file   =   str_replace("RRDBNAME",trim($_POST["dbname"]),$file);
        $file   =   str_replace("RRUSER",trim($_POST["dbusername"]),$file);
        $file   =   str_replace("RRPASS",trim($_POST["dbpass"]),$file);
        $file   =   str_replace("RRHOSTM",trim($_POST["dbhost"]),$file);
        $file   =   str_replace("RRDBNAMEM",trim($_POST["dbname"]),$file);
        $file   =   str_replace("RRUSERM",trim($_POST["dbusername"]),$file);
        $file   =   str_replace("RRPASSM",trim($_POST["dbpass"]),$file);
        $fh     =   fopen('inc/db.php', 'w') or die("Open db.php is impossible. Be sure that this file is on permission 777.");
        fwrite($fh, $file);
        fclose($fh);
        $m  =   '
        <div class="alert alert-success text-center">
            <strong>Tipster Betting Script successfully installed !</strong><br>
            To start , connect with the following information :<br>
            <strong>Username: </strong> admin <br>
            <strong>Password: </strong> admin<br><br>

			<i>You can change your password once connected</i><br>
            <strong>PLEASE DELETE THE FILE install.php ! IS VERY IMPORTANT !</strong><br>
        </div>';
		
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Tipster Betting Script INSTALLATION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Google webfont -->
    <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <!-- FontAwesome css -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Core bootstrap -->
    <link rel="stylesheet" href="assets/bs/css/bootstrap.min.css">
    <!-- Modernizr -->

</head>
<body>

<div class="container-fluid">
    <!--left-->
    <div class="col-sm-12">
        <h1 class="lobster text-center"><i class="fa fa-trophy"></i>&nbsp;Personal tipster betting script installation</h1>
        <div class="panel panel-primary" style="border:1px solid #000000;">
            <div class="panel-heading" style="background:#000000; border:#000000 1px solid;">Configuration</div>
            <div class="panel-body">
                <?php echo $m; ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Your mail address</label>
                        <input type="text" class="form-control" name="admin_mail">
                    </div>
                    <div class="form-group">
                        <label>Choose Website Name</label>
                        <input type="text" class="form-control" name="site_name">
                    </div>
                    <div class="form-group">
                        <label>Choose site description</label>
                        <input type="text" class="form-control" name="site_description">
                    </div>

                    <div class="form-group">
                        <label>Database Host Address</label>
                        <input type="text" class="form-control" name="dbhost">
                    </div>
                    <div class="form-group">
                        <label>Database Name</label>
                        <input type="text" class="form-control" name="dbname">
                    </div>
                    <div class="form-group">
                        <label>Database Username</label>
                        <input type="text" class="form-control" name="dbusername">
                    </div>
                    <div class="form-group">
                        <label>Database Password</label>
                        <input type="text" class="form-control" name="dbpass">
                    </div>
                    <div class="form-group">
                        <label>Your Website Domain</label>
                        <input type="text" class="form-control" name="site_domain">
                    <span id="helpBlock" class="help-block">
                        Website domain. Don't add http://, and without slash to the end.
                        Example: yourwebsite.com<br>
						If you have upload your files inside a folder write like this example : yourwebsite.com/yourfolder/
                    </span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" style="background:#21b100; border:#21b100 1px solid;">Install</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!--/left-->
</div><!--/container-fluid-->

<!-- jQuery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Core Bootstrap -->
<script src="assets/bs/js/bootstrap.min.js"></script>
</body>
</html>