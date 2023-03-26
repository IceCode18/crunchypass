<?php
    require_once __DIR__ . '/../../project/vendor/autoload.php';
    include_once 'model/db.class.php';
    include_once 'model/coupon.class.php';

    use Aws\DynamoDb\DynamoDbClient;
    use Aws\DynamoDb\Exception\DynamoDbException;


    function pasteHeader($title, $linkTitle)
    {
        $count = 0;
        $db = new DB();
        $client = $db->connect();
        if($client){
            $coupon = new Coupon($client);
            $count = $coupon->countCoupons();
        }


        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link href="https://allfont.net/allfont.css?fonts=franklin-gothic-book" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="./css/nav.css">
            <link rel="stylesheet" href="./css/main.css">
            <title><?php echo $title ?></title>
        </head>

        <body>

            <div class="nav-container" id="nav-container">
                <div class="nav">
                    <div class="nav-essentials-container">
                        <a class="main-logo" href="#">
                            <img src="./assets/logo.svg" alt="crunchypass main logo">
                        </a>
                        <a href="javascript:void(0);" class="icon" onclick="navToggle()">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="topnav" id="myTopnav">
                        <a <?php if($linkTitle=="Share") {echo 'class="active" ';} ?>href="index.php">Share</a>
                        <a <?php if($linkTitle=="Claim") {echo 'class="active" ';} ?>href="claim.php">Claim</a>
                        <a <?php if($linkTitle=="Feedback") {echo 'class="active" ';} ?>href="feedback.php">Feedback</a>
                        <a href="https://www.crunchyroll.com/">Crunchyroll</a>
                    </div>
                </div>
                <div class="availability-counter">
                    <span>Unclaimed Pass: <?php echo $count ?></span>
                </div>
            </div>

<?php
    return $client;
}
?>

