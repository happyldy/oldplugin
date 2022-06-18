<?php
/**
 * 术语 foobar, foo, bar, baz 和qux经常在计算机编程或计算机相关的文档中被用作占位符的名字。当变量，函数，或命令本身不太重要的时候，
 * foobar, foo, bar, baz 和qux就被用来充当这些实体的名字，这样做的目的仅仅是阐述一个概念，说明一个想法。这些术语本身相对于使用的场景来说没有任何意义。Foobar经常被单独使用；而当需要多个实体举例的时候，foo，bar，和baz则经常被按顺序使用。
 */

//declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

date_default_timezone_set('Asia/Shanghai');


/**
 * @note header 返回浏览器的数据的单例
 */
HappyLin\OldPlugin\SingleClass\Network\HeaderHelp::getInstance()->setAccessControlAllowOrigin('*');

/**
 * @note 错误捕捉
 */
new HappyLin\OldPlugin\SingleClass\Exceptions\HandleExceptions();

/**
 * @note 路由器
 */
$app = new HappyLin\OldPlugin\SingleClass\FileSystem\PHPFileLink(__FILE__);
$app->route($_GET);