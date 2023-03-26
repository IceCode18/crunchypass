<?php
	include("header.php");
	$client = pasteHeader("Submit","Share");
    $couponC = new Coupon($client);
    
    // filter function
    function filterInput($input){
        $input = trim($input);
        $input = preg_replace('/\s+/', ' ', $input);
        $input = filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!empty($input)) {
            return $input;
        }
        return false;
    }

    // output messages
    $nameCodeError = "Name or code is invalid!";
    $questAnsError = "Challenge or answer is invalid!";
    $success = "Guest Pass submitted!<br>Thank you for helping others out!";
    $codeAlreadyExist = "Sorry!<br>The code has already been submitted by someone else.";
    $message = 'Error!<br>Something must have gone wrong.';
    

    if( (isset($_POST["name"])) && (isset($_POST["code"])) ){ //check if name and code is set
        $from = filterInput($_POST['name']);
        $code = filterInput( preg_replace('/[^a-zA-Z0-9]+/', '', $_POST['code']) );
        if( $code && $from && (strlen($code)==11) ){ // check if input is valid
            if( isset($_POST["challenge-question"]) && isset($_POST["challenge-answer"]) && isset($_POST["challenge-toggle"])){
                $quest = filterInput($_POST['challenge-question']);
                $ans = filterInput($_POST['challenge-answer']);
                if($quest && $ans){ // check if input is valid
                    $result = $couponC->addCoupon($from, $code, $quest, $ans);
                    if($result){
                        $message = $success;
                    }else{
                        $message = $codeAlreadyExist;
                    }
                }else{
                    $message = $questAnsError; // change it to $result = $couponC->addCoupon($from, $code, null, null);
                }
            }else{
                $result = $couponC->addCoupon($from, $code, null, null);
                if($result){
                    $message = $success;
                }else{
                    $message = $codeAlreadyExist;
                }
            }
        }else{
            $message = $nameCodeError;
        }
    }else{
        $message = $nameCodeError;
    }
?>
   
   <div class="main-content-wrapper">
        <div class="title-heading">
            <h1><?= $message ?></h1>
        </div>
    </div>

<script src="./js/main.js"></script>

</body>

</html>