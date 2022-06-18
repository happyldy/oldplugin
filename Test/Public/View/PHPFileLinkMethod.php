<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <!-- 让IE7以下浏览器最大程度的展示bootstrap效果 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- 让视窗宽度与访问设备宽度一致，不做缩放 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

    <link href="./View/css/phpFileLink.css" rel="stylesheet">
</head>
<body>


<div class="plate">

    <div class="dirName">
        <svg class="icon" aria-hidden="true">
            <use xlink:href="#icon-link"></use>
        </svg>
        ：
        <span href="JavaScript:void()"><?php echo $viewData['classname'];?></span><br>
    </div>

    <div class="fileList show">

        <?php

        foreach ($viewData['methodIterator'] as $method){

        ?>
        <div>
            <svg class="icon" aria-hidden="true">
                <use xlink:href="#icon-link"></use>
            </svg>
            ：<a href="?f=<?php echo $viewData['get']['f'];?>&m=<?php echo $method->getName();?>" target="_blank"><?php echo $method->getName();?></a>
            <span style="font-size: 12px">
                <?php

                if(preg_match('/.(?<=@note ).*(?=\\n)/', $reflectionClass->getMethod($method->getName())->getDocComment() , $matches)){
                    echo "--->".$matches[0];
                }

                ?>
            </span>
        </div>


        <?php
        }

        ?>

    </div>
</div>

<div class="code">
    <pre class="pre"><?php echo $viewData['classstr']; ?></pre>
</div>


<script src="./View/js/runtime.7cebb462382338a1edd7.bundle.js"></script>
<script src="./View/js/phpFileLink.fd55731817f11b605373.bundle.js"></script>
</body>
</html>
