<?php
namespace ephp\mvc;

class ActionMailTest {

public $mail_sender;

/**
* @desc Send a test mail to a destination
* @param destination email address to seed the test mail
*/
function test_mail($destination) {
  $this->mail_sender->test($destination);
}

}

