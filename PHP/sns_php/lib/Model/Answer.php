<?php
// 名前空間の設定
namespace MyApp\Model;

class Answer extends \MyApp\Model {
  // 投票結果保存関数
  public function save() {
    // SQL作成
    $sql = "insert into answers
            (answer, created, answer_date)
            values (:answer, now(), now())";
    $stmt = $this->db->prepare($sql);


    // 値の設定
    $stmt->bindValue(':answer', (int)$_POST['answer'], \PDO::PARAM_INT);

    // SQL実行
    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception('予期せぬエラーが発生しました。');
    }
  }

  // 投票結果削除関数
  public function reset() {
    // SQ作成
    $sql = "delete  from answers";
    $stmt = $this->db->prepare($sql);

    // SQLの実行
    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception('予期せぬエラーが発生しました。');
    }
  }

  // 結果取得関数
  public function getALL($data) {
    // SQ作成
    $sql = "select answer, count(id) as c
            from answers
            group by answer";

    // 結果の取得
    foreach ($this->db->query($sql) as $row) {
      $data[$row['answer']] = (int)$row['c'];
    }

    return $data;
  }
}
