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

<div id="pageList">
    <div class="plate" id="">
        <div class="dirName"></div>
        <div class="fileList show">


         
<?php


        function recursiveFile($recursiveDirectoryIterator)
        {

            $fileHtml = '';

            foreach ($recursiveDirectoryIterator as $filename=>$item){

//                echo str_repeat( '&nbsp; &nbsp;', $n) . ' SubPathName: ' . $recursiveDirectoryIterator->getSubPathName() . "\n";
//                echo str_repeat( '&nbsp; &nbsp;', $n) . ' SubPath:     ' . $recursiveDirectoryIterator->getSubPath() . "\n\n";
//                echo str_repeat( '&nbsp; &nbsp;', $n) . ' n:     ' . $n . "\n\n";
//                echo str_repeat( '&nbsp; &nbsp;', $n) . ' filename:     ' . $filename . "\n\n";
//                echo str_repeat( '&nbsp; &nbsp;', $n) . ' $item:     ' . $item . "\n\n";
//                echo "<br>";

                if($item->isDir()){
                    echo "
                    <div class=\"plate\" id=\"\">
                        <div class=\"dirName\">
                            <svg class=\"icon\" aria-hidden=\"true\">
                                <use xlink:href=\"#icon-wenjianjia\"></use>
                            </svg>
                            ： <span href=\"JavaScript:void()\">{$filename}</span><br>
                        </div>
                        <div class=\"fileList show\" style=\"height: 0px; opacity: 0; display: none;\">";

                        if( $recursiveDirectoryIterator->hasChildren()){
                            recursiveFile( $recursiveDirectoryIterator->getChildren());
                        }

                    echo "        
                        </div>
                    </div>";


                }else{
                    $fileHtml .= "
                    <div>
                        <svg class=\"icon\" aria-hidden=\"true\">
                            <use xlink:href=\"#icon-wenjian\"></use>
                            </svg>
                            ：<a href=\"?f={$recursiveDirectoryIterator->getSubPathName()}\" target=\"_blank\">{$filename}</a><br>
                    </div>";
                }

            }

            echo $fileHtml;
        }
        
        recursiveFile($recursiveDirectoryIterator);
        

?>

        </div>
    </div>
</div>

<script src="./View/js/runtime.7cebb462382338a1edd7.bundle.js"></script>
<script src="./View/js/phpFileLink.fd55731817f11b605373.bundle.js"></script>
<script>
    let dropDownDrawerRecursion = new DropDownDrawerRecursion(
        {
            topElement: document.getElementById('pageList'), //事件是加载在它身上的
            drawerClassName: 'plate', //
            butClassName:'dirName', // 文件夹标签即按钮
            conClassName:'fileList', // 文件夹标签即内容
            // throughMethod: 'classname',
            // classname:{
            //     addOrRemoveClassname:'show', // 要添加和移除的className类名，如果使用className模式必填； 类型：string
            //     addOrRemoveElem:'conClassName' //要添加和移除的className类名的目标节点， 默认 conClassName 可选【topDocument，drawerClassName，butClassName，conClassName】
            // },
            // throughMethod: 'callback',
            // callback:{
            //     callback1:function (res){console.log(res)},
            // },
        }
    );
    dropDownDrawerRecursion.execute();
    
</script>
</body>
</html>
