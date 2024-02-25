<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>解决您的问题</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    // 读取 JSON 文件
    $json_file = '1.json';
    $json_data = file_get_contents($json_file);
    // 解析 JSON
    $questions = json_decode($json_data, true);
    $test = myRand();
    $progress = 1;

    // 检查用户是否提交了答案
    function myRand()
    {
        $numbers = range(0, 20); // 你可以更改这个范围来满足你的需求
        shuffle($numbers);
        $result = array_slice($numbers, 0, 5);
        return $result;
        // print_r($result);
    }
    ?>
    <header class="head">
        <h1 class="title">默念心中的问题 追寻答案</h1>
    </header>
    <div class="parent">

        <form id="answerForm" method="post" action="get.php" onsubmit="return submitForm();">
            <?php
            foreach ($test as $key) : ?>
                <?php echo "<div class='question' id='question" . $progress . "'>" ?>
                <p><?php echo $questions[$key]['question']; ?></p>

                <?php
                $mprogress = 0;
                foreach ($questions[$key]['options'] as $val) : ?>
                    <div class="input" id="<?php echo 'div' . $mprogress; ?>" onclick="selectRadio('<?php echo 'div' . $mprogress; ?>','<?php echo $key . $mprogress; ?>')">
                        <input type="radio" id="<?php echo $key . $mprogress; ?>" name="answer<?php echo $progress; ?>" value="<?php echo $questions[$key]['question'] . $val; ?>">
                        <?php echo $val . "<br>"; ?>
                    </div>
                <?php $mprogress++;
                endforeach; ?>
                <?php echo "<button class='btn' onclick=\"showNextQuestion('question" . $progress . "')\"" . ">提交</button>"; ?>
                <?php echo "</div>"; ?>
            <?php
                $progress++;
                $mprogress = 0;
            endforeach; ?>
        </form>
        <div id="result"></div>
    </div>
    <script src="script.js"></script>
</body>

</html>