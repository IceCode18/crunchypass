<?php
    require_once __DIR__ . '/../../project/vendor/autoload.php';
    include_once 'model/db.class.php';
    include_once 'model/coupon.class.php';
    

    $db = new DB();
    $client = $db->connect();
    if($client){
        $couponC = new Coupon($client);

        if( (isset($_POST["cardID"])) && (isset($_POST["answer"])) ){ //check if id and answer is set
            $id = filterInput($_POST["cardID"]);
            $answer = filterInput($_POST["answer"]);
            $claimer = "Anonymous";
            if(isset($_POST["claimer"])){
                $claimerInput = filterInput($_POST["claimer"]);
                if($claimerInput){
                    $claimer = $claimerInput;
                }
            }
            if($id && $answer){ //check if  id and answer are not empty
                $coupon = $couponC->getCouponById($id);
                if(array_key_exists('quest_ans', $coupon)){ // checks if challenge is a custom challenge
                    $ans_array = explode(",", $coupon['quest_ans']['S']);
                    $answer = strtolower($answer);
                    if (in_array($answer, $ans_array)) {
                        // Update the item with the claimer name if it hasn't already been claimed
                        if(!(array_key_exists('claimer', $coupon))){
                            $couponC->updateCouponClaimer($id, $claimer);
                        }
                        // redirect and show the code
                        $code = $coupon['code']['S'];
                        header("Location: success.php?code=" . urlencode($code));
                        exit();
                    }else{
                        // redirect and say wrong answer
                        $result = 'wrong';
                        header('Location: challenge.php?id=' . urlencode($id) . '&result=' . urlencode($result));
                        exit();
                    }
                }elseif (strtoupper($coupon['code']['S']) == strtoupper($answer) ){ // checks if the answer matches the coupon code
                    // Update the item with the claimer name if it hasn't already been claimed
                    if(!(array_key_exists('claimer', $coupon))){
                        $couponC->updateCouponClaimer($id, $claimer);
                    }
                    // redirect and show the code
                    $code = $coupon['code']['S'];
                    header("Location: success.php?code=" . urlencode($code));
                    exit();

                }else{
                    // redirect and say wrong answer
                    $result = 'wrong';
                    header('Location: challenge.php?id=' . urlencode($id) . '&result=' . urlencode($result));
                    exit();
                }
            }else{
                // redirect and say invalid input
                $result = 'invalid';
                header('Location: challenge.php?id=' . urlencode($id) . '&result=' . urlencode($result));
                exit();
            }
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

?>