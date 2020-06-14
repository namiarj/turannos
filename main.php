<?php

define(BOT_TOKEN, "1249263923:AAFFIEkgyBn4231aPE7CdjIcfTG2q9Rqf0g");

function restrictUser($chat_id, $user_id, $permissions, $ban_until) {
	$permissions = urlencode(json_encode($permissions));
	$url = "https://api.telegram.org/bot" . BOT_TOKEN . "/restrictChatMember?chat_id=$chat_id&user_id=$user_id&permissions=$permissions&until_date=$ban_until";
	return file_get_contents($url);
}

$json_input = file_get_contents('php://input');
$input_arr = json_decode($json_input, TRUE);

$user_id = $input_arr["message"]["from"]["id"];
$chat_id = $input_arr["message"]["chat"]["id"];
$date = $input_arr["message"]["date"];

$ban_until = $date + (3600 * 24 * 3); // Ban for 3 days

$permissions = array(
	"can_send_messages" => false,
	"can_send_media_messages" => false,
	"can_send_polls" => false,
	"can_send_other_messages" => false,
	"can_add_web_page_previews" => false,
	"can_change_info" => false,
	"can_invite_users" => false,
	"can_pin_messages" => false,
);

if (isset($input_arr["message"]["new_chat_participant"])) {
	restrictUser($chat_id, $user_id, $permissions, $ban_until);
}

return 0;

?>
