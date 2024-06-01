<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Mail_model extends CI_Model {

		
	 
		public function send_mail($user_data)
		{
			require_once('/var/www/html/mailchimp-transactional-php-master/vendor/autoload.php');
			try {
				if($user_data['mail_type'] == 'hospital_onboard') {
					$htmlContent = $this->user_welcome_mail_content($user_data);
				} else if($user_data['mail_type'] == 'staff_onboard') {
					$htmlContent = $this->staff_welcome_mail_content($user_data);
				} else if($user_data['mail_type'] == 'booking_rejection') {
					$htmlContent = $this->booking_rejection_mail_content($user_data);
				} else if($user_data['mail_type'] == 'hospital_signup_verify') {
					$htmlContent = $this->hospital_signup_verify_mail_content($user_data);
				}
				
				$message = [
				    "from_email" => "internal@idhs.in",
				    "subject" => $user_data['subject'],
				    "html" => $htmlContent,
				    "to" => [
				        [
				            "email" => $user_data['email'],
				            "type" => "to"
				        ]
				    ]
				];
		        $mailchimp = new MailchimpTransactional\ApiClient();
		        $mailchimp->setApiKey('md-nn4tuM_tJHL6zJ_vBF8GKA');

		        $response = $mailchimp->messages->send(["message" => $message]);
		        return $response;
		    } catch (Error $e) {
		        return $e->getMessage();
		    }
		}

		public function user_welcome_mail_content($user_data)
		{
			$htmlContent = "<html>
			<body>
			  <p>Dear ".$user_data['name'].",</p>
			  <p>Welcome to IDHS! We're thrilled to have you join our health community. You're now part of a group that values health and prosperity.</p>
			  <p>Here are your account details:</p>
			  <span>Customer ID: ".$user_data['email']."</span><br>
			  <span>Password: ".$user_data['password']." (Change password while first login)</span><br><br>
			  <span>Access Your Hospital portal from here:</span><br>
			  <span><a href='https://account.idhs.in/hospital/login' target='_blank'>https://account.idhs.in/hospital/login</a></span>
			  <p>Once you've logged in, take some time to explore our platform. You'll find various management features which help manage your hospital well with ease. Kindly setup your hospital details with high integrity.</p>
			  <span>Need Help?</span><br>
			  <span>If you have any questions or need assistance getting started, our support team is here for you. You can reach us at <a href='mailto:support@idhs.in'>support@idhs.in</a> or call us at +919523484666.</span>
			  <p>We are extremely pleased to onboard you to our IDHS family! We also look forward to growing together.</p>
			  <p>Warm regards,</p>
			  <span>TEAM IDHS</span><br>
			  <span>+919523484666</span>
			</body>
			</html>";
			return $htmlContent;
		}

		public function staff_welcome_mail_content($user_data)
		{
			$htmlContent = "<html>
			<body>
			  <p>Dear ".$user_data['name'].",</p>
			  <p>Welcome to the team at ".$user_data['hospital_name']."! We're glad to have you with us.</p>
			  <p>Note:IDHS platform is essential for your day-to-day activities and communication within the hospital.</p>
			  <span>Your login details are:</span><br>
			  <span>User ID: ".$user_data['email']."</span><br>
			  <span>Password: ".$user_data['password']."</span><br><br>
			  <p>To access the Staff Panel, follow these steps:</p>
			  <span>1.Visit the Staff Panel login page</span><br>
			  <span>2.Enter your User ID and Password provided above.</span><br>
			  <span>3.You will be prompted to change your password. Please follow the instructions to set a new, secure password.</span><br><br><br>
			  <span>Access the staff panel here:</span><br>
			  <span><a href='https://account.idhs.in/hospital/login' target='_blank'>https://account.idhs.in/hospital/login</a></span><br><br>
			  <p>If you need help or have any questions, please reach out to IDHS IT support at <a href='mailto:support@idhs.in'>support@idhs.in</a> or call us at +919523484666.</p><br>
			  <p>Welcome aboard!</p>
			  <p>Warm regards,</p>
			  <span>Best,</span><br>
			  <span>".$user_data['hospital_name']."</span>
			</body>
			</html>";
			return $htmlContent;
		}

		public function booking_rejection_mail_content($user_data)
		{
			$htmlContent = "<html>
				<body>
				  <p>Dear ".$user_data['name'].",</p>
				  <p>We regret to inform you that your appointment on ".$user_data['schedule_date_time']." needs to be rescheduled due to doctor's unavailability.</p>
				  <p>Please reschedule at your convenience:</p>
				  <span>Online: [Link to Portal/App]</span><br>
				  <span>Call Us: +919523484666</span><br>
				  <span>Email: <a href='mailto:support@idhs.in'>support@idhs.in</a></span><br><br>
				  <p>We appreciate your understanding and flexibility regarding this matter. At ".$user_data['hospital_name'].", we strive to ensure the highest quality of care for our patients and look forward to serving your healthcare needs promptly.</p>
				  <p>We apologize for any inconvenience and appreciate your understanding. Thank you for choosing IDHS.</p><br>
				  <span>Warm regards,</span><br>
				  <span>TEAM IDHS</span><br>
				</body>
				</html>";
			return $htmlContent;
		}

		public function hospital_signup_verify_mail_content($user_data)
		{
			$htmlContent = "<html>
			<body>
			  <p>Dear ".$user_data['name'].",</p>
			  <p>Welcome to IDHS! We're thrilled to have you join our health community. Please verify your account so that You can be part of us.</p><br>
			  <p>Here are verification details:</p>
			  <span><a href='https://account.idhs.in/".$user_data['verifyUrl']."' target='_blank'>Click Here</a></span><br>
			  <span>OTP: ".$user_data['otp']."</span><br><br>
			  <p>Once you verify your account, we will review your account and get back to you.</p>
			  <span>Need Help?</span><br><br>
			  <span>If you have any questions or need assistance getting started, our support team is here for you. You can reach us at <a href='mailto:support@idhs.in'>support@idhs.in</a> or call us at +919523484666.</span><br>
			  <p>We are extremely pleased to onboard you to our IDHS family! We also look forward to growing together.</p>
			  <p>Warm regards,</p>
			  <span>TEAM IDHS</span><br>
			  <span>+919523484666</span>
			</body>
			</html>";
			return $htmlContent;
		}
	}
