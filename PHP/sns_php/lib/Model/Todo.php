<?php
// 名前空間の設定
namespace MyApp\Model;

class Todo extends \MyApp\Model {
  // Todoリスト取得関数
  public function getAll() {
    // SQL作成
    $sql = "select * from todos order by id desc";

    // 取得
    $stmt = $this->db->query($sql);

    // オブジェクトにして返却
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // Todo作成関数
  public function create() {
    // Todoが指定されているか判定
    if (!isset($_POST['title']) || $_POST['title'] === '') {
      throw new \Exception('[create] title not set!');
    }

    // SQL作成
    $sql = "insert into todos (title) values (:title)";

    // SQL実行
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':title' => $_POST['title']]);

    // 配列で返却
    return [
      'id' => $this->db->lastInsertId()
    ];
  }

  // Todo更新関数
  public function update() {
    // IDが指定されているか判定
    if (!isset($_POST['id'])) {
      throw new \Exception('[update] id not set!');
    }

    // トランザクション開始
    $this->db->beginTransaction();

    // 更新用のSQL作成
    $sql = sprintf("update todos set state = (state + 1) %% 2 where id = %d", $_POST['id']);

    // SQL実行
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    // 取得用のSQL作成
    $sql = sprintf("select state from todos where id = %d", $_POST['id']);

    // SQL実行
    $stmt = $this->db->query($sql);

    // 結果の取得
    $state = $stmt->fetchColumn();

    // コミット
    $this->db->commit();

    // 配列で返却
    return [
      'state' => $state
    ];
  }

  // Todo削除関数
  public function delete() {
    // IDが指定されているか判定
    if (!isset($_POST['id'])) {
      throw new \Exception('[delete] id not set!');
    }

    // SQL作成
    $sql = sprintf("delete from todos where id = %d", $_POST['id']);

    // SQL実行
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return [];
  }
}
