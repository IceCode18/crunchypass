<?php
    include("header.php");
    $client = pasteHeader("Share a Pass", "Share");
?>
<div class="main-content-wrapper">
    <div class="shout-out col">
      <h1>SHARE</h1>
      <h1>YOUR</h1>
      <h1>PASS</h1>
    </div>
    <div class="content col col-60">
      <form id="code-submit-form" action="submit.php" method="post" onsubmit="return validateCouponSubmitForm()">
        <div class="input-fields-container">
          <label class="name-label" for="name"><span>Name:</span></label>
          <input class="name-input" type="text" id="name" name="name" minlength=3 maxlength=15 pattern="\S+" required>
          <br>
          <label class="code-label" for="code"><span>Enter your code below:</span></label>
          <input class="code-input" type="text" id="code" name="code" minlength=11 maxlength=11 pattern="[a-zA-Z0-9]+" required>
        </div>
        <br>
        <div class="slider-container">
          <h3>Add a custom challenge?</h3>
          <br>
          <label id="toggle-label" class="toggle-switch">
          <input type="checkbox" id="challenge-toggle" name="challenge-toggle">
            <span class="slider"></span>
          </label>
        </div>

        <div id="challenge-create" class="input-fields-container">
          <textarea placeholder="Type your question here... (max 250 characters)" id="challenge-question" name="challenge-question"
                    maxlength="250"></textarea>
          <input class="challenge-answer-input" type="text" id="challenge-answer" name="challenge-answer" placeholder="Type answers separated by comma">
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