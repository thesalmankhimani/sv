<?php
/**
 * Created by PhpStorm.
 * User: Salman
 * Date: 7/13/2018
 * Time: 1:31 AM
 */

// include config
include_once 'config.php';

// trim request vars
array_walk($_REQUEST, function (&$val) {
    $val = is_string($val) ? trim($val) : $val;
});

// declare default classes
$db_class = new MysqliDb (DB_HOST, DB_USER, DB_PASS, DB_NAME);
$db_con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// default action
$_REQUEST['action'] = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
// defaults
$json_response = ['error' => 1];
// switch case
switch ($_REQUEST['action']) {
    // post / signin
    case 'post_user':
        // insert or update
        try {
            // insert / update
            $db_class->rawQuery('INSERT INTO `users` (platform_type, platform_id, first_name, last_name, `name`, image_url, created_at, last_seen_at)
VALUES ("google", "' . $_REQUEST['id'] . '", "' . $_REQUEST['first_name'] . '",
"' . $_REQUEST['last_name'] . '", "' . $_REQUEST['name'] . '", "' . $_REQUEST['image_url'] . '",
 "' . date(DB_DATE_FORMAT) . '", "' . date(DB_DATE_FORMAT) . '") 
ON DUPLICATE KEY
    UPDATE last_seen_at = "' . date(DB_DATE_FORMAT) . '";');

            // get user data
            $user = $db_class->where('platform_id', $_REQUEST['id'])
                ->getOne('users');

            // set into session
            $_SESSION['auth'] = $user;

            // success
            $json_response['user'] = $user;
            $json_response['error'] = 0;

        } catch (Exception $e) {
            $json_response['message'] = $e->getMessage();
        }

        exit(json_encode($json_response));
        break;

    // load streaming
    case 'load_streaming' :
        // load lib
        $curl_lib = new Curl();
        // load streaming json from google
        $streaming_url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&eventType=live&type=video&videoCategoryId=20&regionCode=US&maxResults=12&key=' . GOOGLE_SERVER_KEY;
        //$streaming_json = trim(file_get_contents($streaming_url));
        $curl_lib->get($streaming_url);

        try {
            $data['streaming_json'] = json_decode($curl_lib->response);
            $data['db_class'] = $db_class;
            $data['db_con'] = $db_con;

            $json_response['error'] = 0;
            $json_response['html'] = $common_class->view('load_streaming', $data);
        } catch (Exception $e) {
            $json_response['message'] = $e->getMessage();
        }

        exit(json_encode($json_response));
        break;

    // get stream
    case 'get_stream' :

        // get stream by video id
        $data['stream'] = $db_class->where('video_id', $_REQUEST['video_id'])
            ->getOne('streams');
        $data['db_class'] = $db_class;
        $data['db_con'] = $db_con;

        $json_response['error'] = 0;
        $json_response['html'] = $common_class->view('get_stream', $data);

        exit(json_encode($json_response));
        break;

    // get stream
    case 'load_chat' :

        // get stream by video id
        /* $data['stream'] = $db_class->where('video_id', $_REQUEST['video_id'])
             ->getOne('streams');*/
        $data['db_class'] = $db_class;
        $data['db_con'] = $db_con;

        // get chats
        $sql = 'SELECT m.`message`, m.`created_at`, m.`id`, u.`first_name`, u.`last_name`, u.`id` as user_id, u.`image_url`
        FROM messages m
        INNER JOIN streams s ON s.`id` = m.`stream_id`
        INNER JOIN users u ON u.`id` = m.`user_id`
        WHERE s.`video_id` = ?
        ORDER BY m.`created_at` ASC;';

        $data['chats'] = $db_class->rawQuery($sql, [$_REQUEST['video_id']]);

        // get new data
        $stream = $db_class->where('video_id', $_REQUEST['video_id'])
            ->getOne('streams');

        $json_response['error'] = 0;
        $json_response['html'] = $common_class->view('load_chat', $data);

        exit(json_encode($json_response));
        break;

    // post chat
    case 'post_chat':
        // insert or update
        try {
            // def
            $date = date('Y-m-d H:i:s');
            $stream = $db_class->where('video_id', $_REQUEST['video_id'])
                ->getOne('streams');


            // if got valid stream and message
            if ($stream && $_REQUEST['message'] != '') {
                // insert
                $db_class->insert('messages', [
                    'user_id' => $_SESSION['auth']['id'],
                    'message' => $_REQUEST['message'],
                    'stream_id' => $stream['id'],
                    'created_at' => $date
                ]);

                // update stats
                $sql = "UPDATE `streams` SET
                `last_chat_at` = '" . $date . "',
                `chat_count` = chat_count+1,
                `chat_user_count` = (SELECT COUNT(DISTINCT user_id) FROM messages WHERE stream_id = " . $stream['id'] . ")
                WHERE `id` = " . $stream['id'] . "
                ";
                $db_class->rawQuery($sql);

                // get new data
                $stream = $db_class->where('video_id', $_REQUEST['video_id'])
                    ->getOne('streams');
            }

            $json_response['error'] = 0;
            $json_response['stream'] = $stream;

        } catch (Exception $e) {
            $json_response['message'] = $e->getMessage();
        }

        exit(json_encode($json_response));
        break;
    // logout
    case 'logout' :
        unset($_SESSION['auth']);
        header('location:' . APP_URL);
        exit;
        break;

    default :
        $json_response['error'] = 0;

        if ($common_class->checkAuth()) {
            $json_response['html'] = $common_class->view('main');
        } else {
            $json_response['html'] = $common_class->view('login');
        }
        exit(json_encode($json_response));
        break;
}