<?php
/**
 * header函数帮助 参考文档 https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers
 *
 * 方法以
 * shortcut*开头函数为，为立即执行header的快捷方法；返回不定【这个可以拉出去独立，以后说吧】
 * flexible*开头批量缓存header选项的快捷方法；返回$this
 * set*开头就是单独缓存header选项方法；返回$this
 * execute()方法执行全部header选项然后清空所有选项； 无返回
 *
 *
 *
 * COEP：跨域嵌入策略
 * COOP：跨域开放者策略
 * CORP：跨域资源策略)
 * CORS：跨域资源共享
 * CORB：跨域读取阻止
 * 
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Network;

use http\Exception\InvalidArgumentException;

trait HeaderShortcut
{
    
    /**
     * 对当前文档禁用缓存
     * @return HeaderHelp $this
     */
    public function flexibleDisableCache():HeaderHelp
    {
        // 对当前文档禁用缓存
        array_push(
            $this->headerOption,
            'Cache-Control: no-cache, no-store, max-age=0, must-revalidate, post-check=0, pre-check=0',
            'Expires: Mon, 26 Jul 1997 05:00:00 GMT',
            'Pragma: no-cache'
        );
        return $this;
    }


    /**
     * 慢慢加内容
     */
    public function shortcutCommon()
    {
        $this->setDate(gmdate("D, d M Y h:i:s T "));
        $this->setConnection("keep-alive");
        $this->setKeepAlive("timeout=5, max=1000");
    }

    /**
     * 快捷方法 PHP 跨域资源共享 (CORS Cross-origin resource sharing) 中间件
     * @param string $origin 域名或*
     * @param string $method  允许方法选项POST, GET, OPTIONS, DELETE
     * @param int $maxAge   preflight request （预检请求）有效时间；秒
     * @param string $header 首部信息将会出现的字段
     */
    public function shortcutCORS(string $origin='*', $method='POST, GET, OPTIONS, DELETE', int $maxAge=86400, $header='content-type,x-requested-with'):void
    {
        
        $this->_transformation('Access-Control-Allow-Origin',$origin,true);
        $this->_transformation('Access-Control-Allow-Methods',$method,true);
        $this->_transformation('Access-Control-Max-Age',$maxAge,true);
        $this->_transformation('Access-Control-Allow-Headers',$header,true);
    }



    /**
     * 重定向到新地址
     * header('Location: http://www.example.org/');
     * header('Refresh: 10; url=http://www.example.org/'); 10秒后跳转
     * <meta http-equiv="refresh" content="10;http://www.example.org/ />; 10秒后跳转
     * 
     * @param string $url
     * @param int $second
     */
    public function shortcutRedirect(string $url, int $second=0)
    {
        
        $this->headerOptions['Refresh'] = sprintf(' %s; url=%s', $second, $url);
    }



    

    private function other()
    {
        // override X-Powered-By: PHP:
        header('X-Powered-By: PHP/4.4.0');
        header('X-Powered-By: Brain/0.6b');

        //文档语言
        header('Content-Language: en');
        

        //告诉浏览器文档内容没有发生改变
        header('HTTP/1.1 304 Not Modified');


        //显示登陆对话框
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="Top Secret"');
        print 'Text that will be displayed if the user hits cancel or ';
        print 'enters wrong login data';



        //多段下载  Accept-Ranges: bytes | none；  Accept-Ranges 首部（并且它的值不为 “none”），那么表示该服务器支持范围请求
        header('Accept-Ranges: bytes');



    }



}












