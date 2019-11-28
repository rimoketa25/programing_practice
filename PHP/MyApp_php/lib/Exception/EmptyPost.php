<?php

namespace MyApp\Exception;

class EmptyPost extends \Exception {
  protected $message = 'メールアドレスかパスワードを入力してください！';
}
