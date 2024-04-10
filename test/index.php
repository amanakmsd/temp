<?php

require_once('/var/www/html/mailchimp-transactional-php-master/vendor/autoload.php');

function run(){
 try {
    $mailchimp = new MailchimpTransactional\ApiClient();
    $mailchimp->setApiKey('md-nn4tuM_tJHL6zJ_vBF8GKA');
    $response = $mailchimp->users->ping();
    print '<pre>';print_r($response);
  } catch (Error $e) {
        echo 'Error: ',  $e->getMessage(), "\n";
  }
}
run();
?>