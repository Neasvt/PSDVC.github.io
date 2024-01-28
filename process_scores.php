<?php
// 检测是否有POST请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $scores = [];
  $showRecommendation = false;

  // 假设POST数据中包含了问题和答案
  foreach ($_POST as$question => $answer) {
    if (strpos($question, 'q') === 0) { // 确保只处理问题字段
      $factor =$_POST[$question . '_factor'];
      if (!isset($scores[$factor])) {
        $scores[$factor] = 0;
      }
      $scores[$factor] += $answer;
    }
  }

  // 显示结果并评定程度
  echo '<h3>你的得分如下：</h3>';
  foreach ($scores as$factor => $score) {
    // 将分数除以20
    $scoreNormalized =$score / 20;

    echo '因子' . $factor . '的得分是: ' .$scoreNormalized . ' (原始分: ' . $score . ')<br>';

    // 根据分数评定程度
    if ($scoreNormalized <= 2.5) {
      echo '程度评定: 正常<br>';
    } elseif ($scoreNormalized <= 3.5) {
      echo '程度评定: 轻度<br>';
    } elseif ($scoreNormalized <= 4.5) {
      echo '程度评定: 中度<br>';
      $showRecommendation = true; // 如果有中度的评定，则显示建议
    } else {
      echo '程度评定: 重度<br>';
      $showRecommendation = true; // 如果有重度的评定，则显示建议
    }
  }

  // 根据评定结果给出建议
  if ($showRecommendation) {
    echo '<br><strong class="recommendation">建议:</strong> 由于您的某些因子评定结果为中度或重度，我们建议您去精神科专科进行进一步检查。';
  }
}
?>
