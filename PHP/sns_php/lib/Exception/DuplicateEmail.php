<?php

namespace MyApp\Exception;

class DuplicateEmail extends \Exception {
  protected $message = 'メールアドレスが重複しています！';
}
