<?php
// 名前空間の設定
namespace MyApp;

class Controller {

  private $_errors;
  private $_values;

  public function __construct() {
    // トークン作成
    create_token();

    // 初期化
    $this->_errors = new \stdClass();
    $this->_values = new \stdClass();
  }

  protected function setValues($key, $value) {
    $this->_values->$key = $value;
  }

  public function getValues() {
    return $this->_values;
  }

  protected function setErrors($key, $error) {
    $this->_errors->$key = $error;
  }

  public function getErrors($key) {
    return isset($this->_errors->$key) ?  $this->_errors->$key : '';
  }

  protected function hasError() {
    return !empty(get_object_vars($this->_errors));
  }

  protected function isLoggedIn() {
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

  public function me() {
    return $this->isLoggedIn() ? $_SESSION['me'] : null;
  }
}
