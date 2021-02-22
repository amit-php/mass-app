<?php
function sendPushNotification($pushCode, $userId, $pushTitle, $pushBody){

	$_device_token_id = get_user_meta($userId,'_device_token_id',true);
	$_device_os_name = get_user_meta($userId,'_device_os_name',true);

	if($pushCode == 1 || $pushCode == 2 || $pushCode == 3 || $pushCode == 4){
		$msgTitle = $pushTitle;
		$msgBody = $pushBody;
		$flag = 1;
	}else{
		$flag = 2;
	}


	if($flag != 2){

		if($_device_os_name == 'iOS'){

			if(!empty($_device_token_id)){
				$url = "https://fcm.googleapis.com/fcm/send";
				$token = $_device_token_id;
				
				$serverKey = 'AAAA0g5yJSE:APA91bF-5BSDPREpW1aVBdnpsZmYg8HGt7Rn9npWcSLfK8HUOMUJkcLhDmckqg28wihUjaQOt0mqNc0npZldKzKOzOHIgQx2lOm54RcSLATFYhVTZXoJ1z36_mxv0dNtHZxejNjqSE9t'; // new 1
			
				
				$notification = array(
					'title' => $msgTitle, 
					'text' => $msgBody, 
					'sound' => 'default', 
					'badge' => 0, 
					'notification_type' => $msgTitle,
					'push_code' => $pushCode,
					);

				$arrayToSend = array('to' => $token, 'notification' => $notification, 'content_available'=> true, 'mutable_content'=> true, 'priority'=>'high');
				$json = json_encode($arrayToSend);
				$headers = array();
				$headers[] = 'Content-Type: application/json';
				$headers[] = 'Authorization: key='. $serverKey;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				
				$response = curl_exec($ch);
				
				if($response === FALSE){
					die('Notification Send Error: ' . curl_error($ch));
				}
				curl_close($ch);
			}
		}

		if($_device_os_name == 'Android'){

			if(!empty($_device_token_id)){

				define( 'API_ACCESS_KEY', 'AAAA0g5yJSE:APA91bF-5BSDPREpW1aVBdnpsZmYg8HGt7Rn9npWcSLfK8HUOMUJkcLhDmckqg28wihUjaQOt0mqNc0npZldKzKOzOHIgQx2lOm54RcSLATFYhVTZXoJ1z36_mxv0dNtHZxejNjqSE9t' );

				$singleID = $_device_token_id ; 
				
				$fcmMsg = array(
				'title' => $msgTitle,	
				'body' => $msgBody,
				'sound' => "default",
				"icon" => "appicon"
				);

				$fcmData = array(
				'title' => $msgTitle,
				'message' => $msgBody,	
				'push_code' => $pushCode, 
				);

				$fcmFields = array(
				//'title' => $msgTitle,	
				'to' => $singleID,
				'priority' => 'high',
				'notification' => $fcmMsg,
				'data' => $fcmData
				);

				$headers = array(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
				);

				$ch = curl_init();
				curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
				curl_setopt( $ch,CURLOPT_POST, true );
				curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
				$result = curl_exec($ch );
				curl_close( $ch );
			}
		}
				
	}
}


/********** New Articles Add Notification Starts **********/

function new_article_info($post_id, $post, $update){
    if ($post->post_type == 'articles' && $post->post_status == 'publish' && empty(get_post_meta( $post_id, 'check_if_run_once' ))) {

    		global $post;
        	$postId = $post_id;

        	$fileName = get_the_title($postId);


        	$pushTitle = 'مقال جديد';
        	$pushBody = 'لقد تمت إضافة مقال جديد';
        	$pushCode = 2;


        	$applicationUsrs = get_users('role=application_user_role');

        	foreach($applicationUsrs as $applicationUsr){
        		$userId = $applicationUsr->ID;
        		sendPushNotification($pushCode, $userId, $pushTitle, $pushBody);
        	}
        
    }

    if ($post->post_type == 'video' && $post->post_status == 'publish' && empty(get_post_meta( $post_id, 'check_if_run_once' ))) {

    		global $post;
        	$postId = $post_id;

        	$fileName = get_the_title($postId);


        	$pushTitle = 'فيديو جديد';
        	$pushBody = 'لقد تمت إظافة فيديو جديد';
        	$pushCode = 3;


        	$applicationUsrs = get_users('role=application_user_role');

        	foreach($applicationUsrs as $applicationUsr){
        		$userId = $applicationUsr->ID;
        		sendPushNotification($pushCode, $userId, $pushTitle, $pushBody);
        	}
        
    }

    if ($post->post_type == 'album' && $post->post_status == 'publish' && empty(get_post_meta( $post_id, 'check_if_run_once' ))) {

    		global $post;
        	$postId = $post_id;

        	$fileName = get_the_title($postId);


        	$pushTitle = 'ألبوم صور جديد';
        	$pushBody = 'لقد تم نشر ألبوم صور جديد';
        	$pushCode = 4;


        	$applicationUsrs = get_users('role=application_user_role');

        	foreach($applicationUsrs as $applicationUsr){
        		$userId = $applicationUsr->ID;
        		sendPushNotification($pushCode, $userId, $pushTitle, $pushBody);
        	}
        
    }
}
add_action( 'wp_insert_post', 'new_article_info', 10, 3 );
/********** New Articles Add Notification Ends **********/




function theme_options_menupage_livematch(){
	add_menu_page('Live Match Notification', 'Live Match Notification', 'manage_options', 'live-notification', 'live_match_func','dashicons-chart-pie',3);
}
add_action('admin_menu', 'theme_options_menupage_livematch');

function live_match_func(){
	if(isset($_POST['submit'])){

		$pushCode = 1;

		$pushTitle = $_POST['notification_title'];
        $pushBody = $_POST['notification_message'];

		$applicationUsrs = get_users('role=application_user_role');

    	foreach($applicationUsrs as $applicationUsr){
    		$userId = $applicationUsr->ID;
    		sendPushNotification($pushCode, $userId, $pushTitle, $pushBody);
    	}

	}	
?>
<h2>Live Match Notification</h2>
<form method="post" action="" name="multiplefiled" id="multiplefiled">
<div class="form-group fieldGroup" style="clear:both">
    <div class="input-group">

        <div class="input-group-wrapper">

        	<div class="input-group-info">   
                <h4>Notification Title</h4>
                <input type="text" name="notification_title" class="form-control" placeholder="Add Notification Title" required/>
            </div>

            <div class="input-group-info">   
                <h4>Notification Message</h4>
                <textarea name="notification_message" class="form-control" placeholder="Add Notification message" rows="4" cols="50" required/></textarea>
            </div>

        </div>
        
    </div>
</div>
<div class="clearfix"></div>

<input type="submit" name="submit" class="btn btn-primary" value="SUBMIT">   
</form>
<?php
}	

/*
function addNotificationList($matchId, $prevGoalTm1, $prevGoalTm2, $curGoalTm1, $curGoalTm2){

	global $wpdb;
	$table_name = $wpdb->prefix.'ncl_notification_dt';

	date_default_timezone_set('Asia/Kolkata');
	$curdatetime = date("d-m-Y h:i:s a");

	
	$match_status_pending = "SELECT * FROM $table_name WHERE `sr_tbl_match_id` = '$matchId' ORDER BY `sr_tbl_match_id` DESC";	

	$match_status_pending_results = $wpdb->get_results($match_status_pending);
	$match_status_pending_results_count = count($match_status_pending_results);

	$userId = 5; 
	$pushCode = 1;
	$pushTitle = 'ckTitle';
	$pushBody = 'ckBody';


	//sendPushNotification($pushCode, $userId, $pushTitle, $pushBody);


	if($match_status_pending_results_count == 0){

		//$curGoalTm1 = 0;
		//$curGoalTm2 = 0;

		//$curGoalTm1 = $prevGoalTm1;
		//$curGoalTm2 = $prevGoalTm2;

		$wpdb->insert($table_name, array(
				'sr_tbl_match_id' => $matchId,
				'sr_tbl_tm1_previous_goal' => $prevGoalTm1,
				'sr_tbl_tm2_previous_goal' => $prevGoalTm2, 
				'sr_tbl_tm1_current_goal' => $curGoalTm1,
				'sr_tbl_tm2_current_goal' => $curGoalTm2,
				'sr_tbl_datetime' => $curdatetime
			));

	}else{

		foreach($match_status_pending_results as $match_status_pending_result){

			$ntId = $match_status_pending_result->sr_tbl_nt_id;
			$matchId_new = $match_status_pending_result->sr_tbl_match_id;

			$prevGoalTm1_new = $match_status_pending_result->sr_tbl_tm1_previous_goal;
			$prevGoalTm2_new = $match_status_pending_result->sr_tbl_tm2_previous_goal;

			$curGoalTm1_new = $match_status_pending_result->sr_tbl_tm1_current_goal;
			$curGoalTm2_new = $match_status_pending_result->sr_tbl_tm2_current_goal;

		}

		if($prevGoalTm1_new != $prevGoalTm1){

			$update_score_sql = "UPDATE `ftb_ncl_notification_dt` SET `sr_tbl_tm1_previous_goal` = $prevGoalTm1 WHERE `ftb_ncl_notification_dt`.`sr_tbl_match_id` = '$matchId'";
			$update_score_sql_result = $wpdb->query($update_score_sql);

			$flag = 1;

		}elseif($prevGoalTm2_new != $prevGoalTm2){

			$update_score_sql = "UPDATE `ftb_ncl_notification_dt` SET `sr_tbl_tm2_previous_goal` = $prevGoalTm2 WHERE `ftb_ncl_notification_dt`.`sr_tbl_match_id` = '$matchId'";
			$update_score_sql_result = $wpdb->query($update_score_sql);

			$flag = 1;
		
		}elseif($curGoalTm1_new != $curGoalTm1){

			$update_score_sql = "UPDATE `ftb_ncl_notification_dt` SET `sr_tbl_tm1_current_goal` = $curGoalTm1 WHERE `ftb_ncl_notification_dt`.`sr_tbl_match_id` = '$matchId'";
			$update_score_sql_result = $wpdb->query($update_score_sql);

			$flag = 1;
		
		}elseif($curGoalTm2_new != $curGoalTm2){

			$update_score_sql = "UPDATE `ftb_ncl_notification_dt` SET `sr_tbl_tm2_current_goal` = $curGoalTm2 WHERE `ftb_ncl_notification_dt`.`sr_tbl_match_id` = '$matchId'";
			$update_score_sql_result = $wpdb->query($update_score_sql);

			$flag = 1;
		
		}else{

			$flag = 2;
		}	

	}

}
*/

/*
function before_save_publish($new_status, $old_status, $post){

	if(('publish' === $new_status || 'publish' === $old_status) && 'live' === get_post_type( $post->ID)){
	       
		$prevGoalTm1 = get_post_meta($post->ID, 'total_Score1', true);
		$prevGoalTm2 = get_post_meta($post->ID, 'total_Score2', true);

		global $wpdb;
		$table_name = $wpdb->prefix.'ncl_notification_dt';

		$match_status_pending = "SELECT * FROM $table_name WHERE `sr_tbl_match_id` = '$matchId' ORDER BY `sr_tbl_match_id` DESC";	

		$match_status_pending_results = $wpdb->get_results($match_status_pending);
		$match_status_pending_results_count = count($match_status_pending_results);

		if($match_status_pending_results_count == 0){

			$curGoalTm1 = $prevGoalTm1;
			$curGoalTm2 = $prevGoalTm2;

			addNotificationList($post->ID,$prevGoalTm1,$prevGoalTm2,$curGoalTm1,$curGoalTm2);

		}else{

			foreach($match_status_pending_results as $match_status_pending_result){

				$ntId = $match_status_pending_result->sr_tbl_nt_id;
				$matchId_new = $match_status_pending_result->sr_tbl_match_id;

				$prevGoalTm1_new = $match_status_pending_result->sr_tbl_tm1_previous_goal;
				$prevGoalTm2_new = $match_status_pending_result->sr_tbl_tm2_previous_goal;

				$curGoalTm1_new = $match_status_pending_result->sr_tbl_tm1_current_goal;
				$curGoalTm2_new = $match_status_pending_result->sr_tbl_tm2_current_goal;

			}

			if(!empty($prevGoalTm1)){

				$curGoalTm1 = $curGoalTm1_new;
				$curGoalTm2 = $curGoalTm2_new;

				addNotificationList($post->ID,$prevGoalTm1,$prevGoalTm2,$curGoalTm1,$curGoalTm2);

			}

			if(!empty($prevGoalTm2)){

				$curGoalTm1 = $curGoalTm1_new;
				$curGoalTm2 = $curGoalTm2_new;

				addNotificationList($post->ID,$prevGoalTm1,$prevGoalTm2,$curGoalTm1,$curGoalTm2);

			}


			

		}

		$msg = $prevGoalTm1.'xxxxxxx'.$prevGoalTm2;
			mail("prasun.saha@pkweb.in","My subject",$msg);

	} 
}

add_action( 'transition_post_status', 'before_save_publish', 10, 3 );
*/



/*

add_action( 'save_post', 'after_save_publish', 10,3 );

function after_save_publish( $post_id, $post, $update ) { 
	
	if('live' == $post->post_type) {

		$curGoalTm1 = get_post_meta($post_id, 'total_Score1', true); //after
		$curGoalTm2 = get_post_meta($post_id, 'total_Score2', true); //after


		global $wpdb;
		$table_name = $wpdb->prefix.'ncl_notification_dt';

		$match_status_pending = "SELECT * FROM $table_name WHERE `sr_tbl_match_id` = '$matchId' ORDER BY `sr_tbl_match_id` DESC";	

		$match_status_pending_results = $wpdb->get_results($match_status_pending);
		$match_status_pending_results_count = count($match_status_pending_results);

		foreach($match_status_pending_results as $match_status_pending_result){

			$ntId = $match_status_pending_result->sr_tbl_nt_id;
			$matchId_new = $match_status_pending_result->sr_tbl_match_id;

			$prevGoalTm1_new = $match_status_pending_result->sr_tbl_tm1_previous_goal;
			$prevGoalTm2_new = $match_status_pending_result->sr_tbl_tm2_previous_goal;

			$curGoalTm1_new = $match_status_pending_result->sr_tbl_tm1_current_goal;
			$curGoalTm2_new = $match_status_pending_result->sr_tbl_tm2_current_goal;

		}


		if(!empty($curGoalTm1)){

			$prevGoalTm1 = $prevGoalTm1_new;
			$prevGoalTm2 = $prevGoalTm2_new;

			addNotificationList($post_id,$prevGoalTm1,$prevGoalTm2,$curGoalTm1,$curGoalTm2);

		}

		if(!empty($curGoalTm2)){

			$prevGoalTm1 = $prevGoalTm1_new;
			$prevGoalTm2 = $prevGoalTm2_new;

			addNotificationList($post_id,$prevGoalTm1,$prevGoalTm2,$curGoalTm1,$curGoalTm2);

		}

		$msg = $curGoalTm1.'ddddd'.$curGoalTm2;
		mail("prasun.saha@pkweb.in","My subject",$msg);

	 }

}

*/