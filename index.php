<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>解决您的问题</title>
    <link rel="stylesheet" href="style.css">
</head>


<body onLoad="Autofresh()">
    <?php
    $res = curl_file_get_contents("https://international.v1.hitokoto.cn/");
    $result = json_decode($res, true);
    function curl_file_get_contents($durl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $durl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回    
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
    ?>
    <header class="head">

        <h1 class="title">倾诉所想 留下你的足迹</h1>
        <button type="button" class="headBtn" id="askButton"><span class="ask-btn">问个问题</span></button>
    </header>
    <div class="parent">
        <div class="connect">
            <h1>连接心灵，交流美好</h1>
            <h4>每日一言：<?php echo $result['hitokoto']; ?> </h4>
            <form action='message.php' method='post' id='messageForm' onsubmit="return validataForm();">
                昵称：<input type='text' name='username' id='username'><span id="username-error" style="color: red;"></span><br />
                留言内容：<textarea name='message' id='text' rows='1' cols='30'></textarea>
                <span id="text-error" style="color: red;"></span>
                <input id='btn' type='submit' value='发表留言' />
            </form>
            <div id='box'>
            </div>
            <!-- <div id="login-box">
                <a id="login-text" href="login.html">登录/注册</a>
            </div> -->
        </div>
    </div>
</body>
<script>
    var xmlobj;
    var count = 0;

    function createXMLHttpRequest() {
        if (window.ActiveXObject) {
            xmlobj = new ActiveXObject("Microsoft.XMLHTTP");
        } else if (window.XMLHttpRequest) {
            xmlobj = new XMLHttpRequest();
        }
    }

    function Autofresh() {
        createXMLHttpRequest();
        count = count + 1;
        xmlobj.open("POST", "display.php", true);
        xmlobj.onreadystatechange = doAjax;
        xmlobj.send("r=" + Math.random()); //使用随机数处理缓存
    }

    function doAjax() {
        if (xmlobj.readyState == 4 && xmlobj.status == 200) {
            var display = document.getElementById('box');
            display.innerHTML = xmlobj.responseText;
            setTimeout("Autofresh()", 1000);
        }
    }
    var askButton = document.getElementById('askButton');
    askButton.addEventListener('click', function() {
        window.location.href = 'ask.php';
    });

    function validataForm() {
        var username = document.getElementById("username").value;
        var text = document.getElementById("text").value;
        var errorSpan_username = document.getElementById("username-error");
        var errorSpan_text = document.getElementById("text-error");
        errorSpan_username.textContent = "";
        errorSpan_text.textContent = "";
        if (username == "") {
            errorSpan_username.textContent = " 请填写昵称！";
            return false;
        } else if (text == "") {
            errorSpan_text.textContent = "请填写留言内容！";
            return false;
        }
        return true;
    }
</script>

</html>