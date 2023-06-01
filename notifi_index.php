<html>
    <head>
        <title>IndoorLocation Tracking Firebase Cloud Messaging Backend</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="//www.gstatic.com/mobilesdk/160503_mobilesdk/logo/favicon.ico">
        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
        <link rel="stylesheet" type="text/css" href="firebase.css">
    </head>
    <body>
        <?php
        // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');

        include 'firebase.php';
        include 'push.php';

        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['team'] = 'Admin';
        $payload['score'] = '1';

        // notification title
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        
        // notification message
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        
        // push type - single user / topic
        $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';

        // shop type
        $bType = isset($_GET['bType']) ? $_GET['bType'] : '';
        
        // whether to include to image or not
        $include_image = isset($_GET['include_image']) ? TRUE : FALSE;


        $push->setTitle($title);
        $push->setMessage($message);
        $push->setBtype($bType);
        if ($include_image) {
            $push->setImage(null);
        } else {
            $push->setImage('');
        }
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = isset($_GET['regId']) ? $_GET['regId'] : '';
            $response = $firebase->send($regId, $json);
        }
        ?>
        <div class="container">
            <div class="fl_window">
                <div><img src="https://cdn-images-1.medium.com/max/840/1*wiNrwnAnwjBzbjlXUgrj6A.png" width="200" alt="Firebase"/></div>
                <br/>
                <?php if ($json != '') { ?>
                    <label><b>Request:</b></label>
                    <div class="json_preview">
                        <pre><?php echo json_encode($json) ?></pre>
                    </div>
                <?php } ?>
                <br/>
                <?php if ($response != '') { ?>
                    <label><b>Response:</b></label>
                    <div class="json_preview">
                        <pre><?php echo json_encode($response) ?></pre>
                    </div>
                <?php } ?>

            </div>

            <form class="pure-form pure-form-stacked" method="get">
                <fieldset style="height: 80%; width: 100%;">
                    <legend>Send to Topic Notification</legend>

                    <div class="div_pattern">
                        <label for="bType">Shop Type: </label>
                        <input type="number" id="bType" name="bType" min="1" max="4" class="pure-input"  required="required">
                    </div>

                    <!-- <label for="title1">Title</label>
                    <input type="text" id="title1" name="title" class="pure-input-1-2" placeholder="Enter title"> -->

                    <div class="div_pattern">
                        <label for="message1" style="display: block;">Message</label>
                        <textarea class="pure-input-1-2" name="message" id="message1" rows="5" placeholder="Notification message!"></textarea>
                    </div>

                    <div class="div_pattern">
                        <input type="hidden" name="push_type" value="topic"/>
                        <button type="submit" class="pure-button pure-button-primary btn_send">Send to Topic</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </body>
</html>
