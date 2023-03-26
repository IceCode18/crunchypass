<?php
	include("header.php");
	$code = 'Not! You tried to be sneaky and failed!';
    if((isset($_GET["code"]))){
		$code = $_GET["code"];
    }
    $client = pasteHeader("Success", "Claim");
?>

<div class="main-content-wrapper">
    <div class="title-heading">
        <h1>Success! Here's your code!</h1>
		<p id="success"><?= $code ?></p>
    </div>
</div>

    <script src="./js/main.js"></script>

</body>

</html>