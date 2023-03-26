<?php
include("header.php");
$client = pasteHeader("Feedback", "Feedback");
$partition = '1';


if (isset($_POST["comment"])) {
    $com = trim($_POST["comment"]);
    $com = preg_replace('/\s+/', ' ', $com);
    if (!empty($com)) {
        $com = addslashes($com);
        $com = htmlspecialchars($com, ENT_QUOTES, 'UTF-8');
        $tableName = 'comments';
        $key = 'u_comment';
        $params = [
            'TableName' => $tableName,
            'FilterExpression' => '#' . $key . ' = :v_' . $key,
            'ExpressionAttributeNames' => ['#' . $key => $key],
            'ExpressionAttributeValues' => [
                ':v_' . $key => ['S' => $com]
            ],
        ];
        $result = $client->scan($params);
        //Add comment if it doesn't exist
        if (count($result['Items']) == 0) {
            date_default_timezone_set('HST');
            $time = date('Y-m-d H:i:s');
            $user = 'Anonymous';
            if (isset($_POST["commentor-name"])) {
                $user_input = trim($_POST["commentor-name"]);
                $user_input = preg_replace('/\s+/', ' ', $user_input);
                $user_input = filter_var($user_input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if (!empty($user_input)) {
                    $user = $user_input;
                }
            }
            $params = [
                'TableName' => $tableName,
                'Item' => [
                    'n' => [
                        'N' => $partition
                    ],
                    'date' => [
                        'S' => $time
                    ],
                    'user' => [
                        'S' => $user
                    ],
                    'u_comment' => [
                        'S' => $com
                    ]
                ]
            ];
            $result = $client->putItem($params);
        }
    }

}

function printComments()
{
    global $client;
    $result = $client->query([
        'TableName' => 'comments',
        'KeyConditionExpression' => '#n = :n_val',
        'ExpressionAttributeNames' => [
            '#n' => 'n',
        ],
        'ExpressionAttributeValues' => [
            ':n_val' => ['N' => '1'],
        ],
        'ScanIndexForward' => false
    ]);
    $comments = $result['Items'];
    
    foreach ($comments as $comment) {
        include('comment-template.html');
    }
}

?>
<div class="main-content-wrapper">
    <div class="title-heading">
        <h1>I would like to hear your feedback!</h1>
    </div>
    <div class="content">
        <form id="feedback-form" action="feedback.php" method="post" onsubmit="return validateFeedbackForm()">
            <div class="input-fields-container textarea-container">
                <div class="name-input-container">
                    <input class="name-input" type="text" id="commentor-name" name="commentor-name"
                        placeholder="Name (optional)" minlength=3 maxlength=15>
                </div>
                <textarea placeholder="Type here... (max 250 characters)" id="comment" name="comment" minlength=4 maxlength="250" required></textarea>
            </div>
            <div class="button-container">
                <input class="send-button" type="submit" value="Submit">
            </div>
        </form>
        <br>
        <div class="comment-section-container">
            <?php printComments() ?>
        </div>

    </div>
</div>

<script src="./js/main.js"></script>

</body>

</html>