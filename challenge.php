<?php 
    include("header.php");

    $result = '';
    $invalid = 'invalid';
    $wrong = 'wrong';

    if((isset($_GET["result"]))){
        $result = $_GET["result"];
    }

    $client = pasteHeader("Solve Challenge", "Claim");
    $couponC = new Coupon($client);

    $couponID = "";
    $owner = "";
    $claimer = null;
    $question = null;
    $randomizedCode = "";

    if((isset($_GET["id"]))){
        $input = filterInput($_GET["id"]);
        if($input){
            $couponID = $input;
        }
        $coupon = $couponC->getCouponById($couponID);
        $owner = $coupon['owner']['S'];
        $question = $coupon['quest']['S'] ?? null;
        $claimer = $coupon['claimer']['S'] ?? null;

        if(is_null($question)){
            $randomizedCode = randomize($coupon['code']['S']);
        }
    }

    

    // filter function for inputs
    function filterInput($input){
        $input = trim($input);
        $input = preg_replace('/\s+/', ' ', $input);
        $input = filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!empty($input)) {
            return $input;
        }
        return false;
    }

    // randomize function for coupons without a custom challenge
    function randomize($str){
		$block = str_split($str, 3);
		shuffle($block);
		return implode(" ", $block);
	}

?>

<div class="main-content-wrapper">
    <div class="title-heading">
        <h1>Crack the challenge!</h1>
        <h3>from: <?= $owner ?></h3>
        <?php 
            if (!is_null($claimer)) { ?>
            <h3>claimed by: <?= $claimer ?></h3>
        <?php } ?>
    </div>
    <div class="content">
        <?php 
            if (!is_null($question)) { ?>
            <p id="challenge"><?= $question ?></p>
            <?php } 
            else{ ?>
                <p id='randomized-code'><?= $randomizedCode ?></p>
                <p id="challenge-description">Rearrange the characters to form the code</p>
        <?php } ?>
        <form action="validate.php" method="post">
            <div class="input-fields-container">
                <input type="text" id="cardID" name="cardID" value="<?= $couponID ?>">
                <?php 
                    if (is_null($claimer)) { ?>
                    <input class="answer-input" type="text" id="claimer" name="claimer" placeholder="Type your name to let the owner know who claimed the code" required>
                    <?php } ?>
                <?php 
                    if (strcmp($result, $invalid) == 0) { ?>
                        <input class="answer-input unsuccessful" type="text" id="answer" name="answer" placeholder="Invalid input!" required>
                    <?php } 
                    elseif(strcmp($result, $wrong) == 0){ ?>
                        <input class="answer-input unsuccessful" type="text" id="answer" name="answer" placeholder="Wrong answer!" required>
                    <?php }
                    else{ ?>
                        <input class="answer-input" type="text" id="answer" name="answer" placeholder="Type your answer here" required>
                    <?php } ?>
            </div>
            <div class="button-container">
                <input class="send-button" type="submit" value="Submit">
            </div>
        </form>
    </div>
</div>

    <script src="./js/main.js"></script>

</body>

</html>