<?php

namespace MyApp\Exception;

class InvalidEmail extends \Exception {
  protected $message = 'メールアドレスの形式が間違っています！';
}
