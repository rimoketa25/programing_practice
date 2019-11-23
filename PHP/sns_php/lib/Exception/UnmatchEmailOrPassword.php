<?php

namespace MyApp\Exception;

class UnmatchEmailOrPassword extends \Exception {
  protected $message = 'メールアドレスかパスワードが正しくありません！';
}
