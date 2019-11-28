<?php
// 名前空間の指定
namespace MyApp\Controller;

class ImageUploader extends \MyApp\Controller {
  // プロパティ宣言
  private $_imageFileName;
  private $_imageType;

  // アップロード関数
  public function upload() {
    try {
      // エラーチェック
      $this->_validateUpload();

      // 拡張子判定
      $ext = $this->_validateImageType();

      // 画像の保存
      $savePath = $this->_save($ext);

      // サムネイル画像の作成
      $this->_createThumbnail($savePath);

      // 正常終了
      $_SESSION['success'] = '画像の追加が完了しました';
    } catch (\Exception $e) {
      // エラー発生
      $_SESSION['error'] = $e->getMessage();
    }

    // リダイレクト処理
    // header('Location: ' . SITE_URL . '/poll.php');
    // exit;
  }

  // 画像削除関数
  public function delete() {

      // 画像フォルダの削除
      foreach (glob(IMAGES_DIR . '/*') as $file){
        if (!unlink($file)){
            $_SESSION['error'] = $file.'の削除に失敗しました。';
            return;
        }
      }

      // サムネイルフォルダの削除
      foreach (glob(THUMBNAIL_DIR . '/*') as $file){
        if (!unlink($file)){
          $_SESSION['error'] = $file.'の削除に失敗しました。';
          return;
        }
      }

      // 正常終了
      $_SESSION['success'] = '画像の削除が完了しました';

      // リダイレクト処理
      header('Location: ' . SITE_URL . '/poll.php');
      exit;
  }

  // 実行結果取得関数
  public function getResults() {
    // 初期化
    $success = null;
    $error = null;

    // セッションに正常値が設定されていれば
    if (isset($_SESSION['success'])) {
      // 保持して、セッションをリセット
      $success = $_SESSION['success'];
      unset($_SESSION['success']);
    }

    // セッションに異常値が設定されていれば
    if (isset($_SESSION['error'])) {
      // 保持して、セッションをリセット
      $error = $_SESSION['error'];
      unset($_SESSION['error']);
    }

    // 結果の配列を返却
    return [$success, $error];
  }

  // 一覧表示用の画像取得関数
  public function getImages() {
    // 初期化
    $images = [];
    $files = [];
    $imageDir = opendir(IMAGES_DIR);

    // 画像保存フォルダにある全ファイルに対して
    while (false !== ($file = readdir($imageDir))) {
      // ファイル以外は処理しない
      if ($file === '.' || $file === '..') {
        continue;
      }

      // ソート用にファイル名を保持
      $files[] = $file;

      // サムネイルフォルダに対象のファイルがあるかの判定
      if (file_exists(THUMBNAIL_DIR . '/' . $file)) {
        $images[] = basename(THUMBNAIL_DIR) . '/' . $file;
      } else {
        $images[] = basename(IMAGES_DIR) . '/' . $file;
      }
    }

    // $files 順に逆向きオプションで $images をソート
    array_multisort($files, SORT_DESC, $images);
    return $images;
  }

  // サムネイル画像作成判定関数
  private function _createThumbnail($savePath) {
    // 保存された画像の情報の取得
    $imageSize = getimagesize($savePath);
    $width = $imageSize[0];
    $height = $imageSize[1];

    // 指定幅より大きければサムネイルの作成
    if ($width > THUMBNAIL_WIDTH) {
      $this->_createThumbnailMain($savePath, $width, $height);
    }
  }

  // サムネイル画像作成関数
  private function _createThumbnailMain($savePath, $width, $height) {
    // 元画像の画像リソースの作成
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        $srcImage = imagecreatefromgif($savePath);
        break;
      case IMAGETYPE_JPEG:
        $srcImage = imagecreatefromjpeg($savePath);
        break;
      case IMAGETYPE_PNG:
        $srcImage = imagecreatefrompng($savePath);
        break;
    }

    // サムネイル画像の高さの計算
    $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);

    // サムネイル画像の元イメージの作成
    $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);

    // 作成した元イメージに画像リソースをコピー
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, $thumbHeight, $width, $height);

    // サムネイル画像の保存
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        imagegif($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_PNG:
        imagepng($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
    }
  }

  // 画像保存関数
  private function _save($ext) {
    // ファイル名の作成
    $this->_imageFileName = sprintf(
      '%s_%s.%s',
      time(), // 現在までの経過ミリ秒
      sha1(uniqid(mt_rand(), true)), // ランダムな文字列
      $ext // 拡張子
    );

    // 保存パスの作成
    $savePath = IMAGES_DIR . '/' . $this->_imageFileName;

    // ファイルの移動
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);

    // 処理結果判定
    if ($res === false) {
      throw new \Exception('Could not upload!');
    }

    // 保存パスの返却
    return $savePath;
  }

  // エラーチェック関数
  private function _validateUpload() {
    // ファイルの存在チェック
    if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \Exception('Upload Error!');
    }

    // エラーチェック
    switch($_FILES['image']['error']) {
      // 正常
      case UPLOAD_ERR_OK:
        return true;

      // サイズオーバー
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Exception('File too large!');

      // 予期せぬエラー
      default:
        throw new \Exception('Err: ' . $_FILES['image']['error']);
    }
  }

  // 拡張子判定関数
  private function _validateImageType() {
    // 拡張子の取得
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);

    // 拡張子判定
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        return 'gif';
      case IMAGETYPE_JPEG:
        return 'jpg';
      case IMAGETYPE_PNG:
        return 'png';
      default:
        throw new \Exception('PNG/JPEG/GIF only!');
    }
  }
}
