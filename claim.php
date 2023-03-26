<?php
    include("header.php");
    $client = pasteHeader("Claim a Pass", "Claim");
    $couponC = new Coupon($client);

    function printCards(){
		global $couponC;
        $coupons = $couponC->getAllCoupons();
        $claimedCoupons = array();
        foreach ($coupons as $coupon) {
            $id = $coupon['n']['N'];
            $randomized = true;
            if(!empty($coupon['quest']['S'])) {
                $randomized = false;
            } 
            $claimed = true;
            if(empty($coupon['claimer']['S'])) {
                $claimed = false;
            } 
            if($claimed){
                array_push($claimedCoupons, $coupon);
            }else{
                include('card-template.html');
            }
        }
        $claimed = true;
        foreach ($claimedCoupons as $coupon) {
            $id = $coupon['n']['N'];
            $randomized = true;
            if(!empty($coupon['quest']['S'])) {
                $randomized = false;
            } 
            include('card-template.html');
        }
	}

?>
    <div class="main-content-wrapper">
        <div class="title-heading">
            <h1>Choose a card!</h1>
        </div>
        <div class="content">
            <div class="cards-container">
                <div class="cards">
                    <?php printCards() ?>
                </div>

            </div>
        </div>
    </div>

    <script src="./js/main.js"></script>

</body>

</html>