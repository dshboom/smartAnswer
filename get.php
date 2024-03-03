<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>解决您的问题</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="head">
        <h1 class="title">默念心中的问题 我们的解答如下</h1>
        <button type="button" class="headBtn" id="lyb-btn"><span class="lyb-btn">留言一下</span></button>

    </header>
    <div id="answer">
        <?php
        // 读取 JSON 文件
        $json_file = '1.json';
        $json_data = file_get_contents($json_file);
        // 解析 JSON
        $questions = json_decode($json_data, true);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // 处理用户的答案
            if (isset($_POST['answer1'])) {
                // 检查答案是否有效
                $res =
                    $_POST['answer1'] . "<br>" .
                    $_POST['answer2'] . "<br>" .
                    $_POST['answer3'] . "<br>" .
                    $_POST['answer4'] . "<br>" .
                    $_POST['answer5'] . "<br>";
                getAnswer($res);
            }
        }
        function getAnswer($res)
        {
            set_time_limit(60);
            $url = 'https://chat.openai.com/v1/chat/completions'; //聊天接口
            $api_key = 'sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxx';  //获取到的api key
            // Request headers
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
            );
            // Request data
            $data = array(
                // 'model' => 'text-davinci-003',
                // 'model' => 'gpt-3.5-turbo', //聊天模型
                'model' => 'gpt-3.5-turbo-1106',
                // 'model' => 'text-curie-001',
                'temperature' => 0.8,
                // 'prompt' => '如何用php使用chatgpt的聊天接口', //聊天不用
                'max_tokens' => 3000,
                'messages' => [
                    ["role" => "user", "content" => "你是一个帮助人类解答问题的智者，我将会把问答记录发给你，你需要根据问答记录解决他的问题，在回答完后你要对你的回答进行关键句提取并总结，作为一个智者，你还要用一个词或一句话给出建议，这个词语或句子要看起来像占卜大师说的话。明白了吗？"],
                    ["role"  =>  "assistant", "content"  =>  "\n\n我明白了！我将会按你说的做，我的回答将在100-300字之间。"],
                    ["role" => "user", "content" => $res]
                ]

            );

            // Send request
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            // print_r(curl_getinfo($ch));
            curl_close($ch);

            // Print response
            // 将 JSON 字符串解码为 PHP 数组
            $data = json_decode($response, true);
            // 提取 message 内容
            $content = "<p id='answer'><br><b>根据您的回答，我们为您提供的建议是：<b><br>" . $data['choices'][0]['message']['content'] . "</p>";

            // 打印提取的内容
            echo $content;
            // print_r($data);
        }
        // function getAnswer($res)
        // {
        //     echo "test";
        // }
        ?>
        <button class='btn' onclick="restart()">再问一次</button>
    </div>
    <script>
        function restart()
        {
            window.location.href = "./index.php";
        }
    </script>
</body>

</html>