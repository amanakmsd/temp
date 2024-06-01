<?php

require_once('/var/www/html/mailchimp-transactional-php-master/vendor/autoload.php');

function run($message)
{
    try {
        $mailchimp = new MailchimpTransactional\ApiClient();
        $mailchimp->setApiKey('md-nn4tuM_tJHL6zJ_vBF8GKA');

        $response = $mailchimp->messages->send(["message" => $message]);
        print_r($response);
    } catch (Error $e) {
        echo 'Error: ', $e->getMessage(), "\n";
    }
}

$htmlContent = "<html>
<body>
  <p>Dear Medanta,</p>
  <p>Welcome to IDHS! We're thrilled to have you join our health community. You're now part of a group that values health and prosperity.</p>
  <p>Here are your account details:</p>
  <span>Customer ID: [Customer ID]</span><br>
  <span>Password: [Password] (Change password while first login)</span><br><br>
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
$message = [
    "from_email" => "internal@idhs.in",
    "subject" => "IDHS Testing",
    "html" => $htmlContent,
    "to" => [
        [
            "email" => "connect@britenext.com",
            "type" => "to"
        ]
    ]
];
run($message);
?>