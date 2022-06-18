<?php
/**
 *
 *
 * 
 */


namespace HappyLin\OldPlugin\SingleClass\Streams;




class StreamFunction
{

   public function __construct()
   {
   }




    /**
     * 创建一个用于当前流的新存储桶
     * @param resource $stream
     * @param string $buffer
     * @return object
     */
    public static function stream_bucket_new( resource $stream, string $buffer) : object
    {
        return stream_bucket_new(  $stream, $buffer);
    }



    /**
     *  Append bucket to brigade 将存储桶附加到旅
     *
     * @param resource $brigade
     * @param object $bucket
     */
   public static function stream_bucket_append(resource $brigade, object $bucket){

       stream_bucket_append(  $brigade,  $bucket);
   }


    /**
     * 将存储桶预置为旅
     * 可以调用此函数将一个桶添加到一个桶旅中。 它通常从 php_user_filter::filter() 调用。
     *
     * @param resource $brigade brigade 是一种资源，指向一个bucket brigade，其中包含一个或多个bucket 对象。
     * @param object $bucket 一个桶对象
     */
    public static function stream_bucket_prepend( resource $brigade, object $bucket) : void
    {
        stream_bucket_prepend( $brigade, $bucket);
    }


    /**
     * 从旅返回一个桶对象以进行操作
     * @param resource $brigade
     * @return object
     */
   public static function stream_bucket_make_writeable( resource $brigade) : object
   {
       return stream_bucket_make_writeable( $brigade);
   }






   // ···························· 资源流上下文··································



    /**
     * 设置默认流上下文
     * 设置默认流上下文，该上下文将在没有上下文参数的情况下调用文件操作（fopen()、file_get_contents() 等）时使用。 使用与 stream_context_create() 相同的语法。
     *
     * @param array $options
     * @return resource
     */
    public static function stream_context_set_default( array $options)
    {
        return stream_context_set_default( $options) ;
    }

    /**
     * 检索默认流上下文
     * 返回在没有上下文参数的情况下调用文件操作（fopen()、file_get_contents() 等）时使用的默认流上下文。 可以使用与 stream_context_create() 相同的语法通过此函数选择指定默认上下文的选项。
     *
     * stream_context_set_default() 函数可用于设置默认上下文。
     *
     * @param array $options options 必须是 $arr['wrapper']['option'] = $value 格式的关联数组的关联数组。
     * @return resource
     */
    public static function stream_context_get_default(array $options) : resource
    {
        return stream_context_get_default($options);
    }



    /**
     * 创建资源流上下文
     * 创建并返回一个资源流上下文，该资源流中包含了 options 中提前设定的所有参数的值。
     *
     * @param array $option 必须是一个二维关联数组，格式如下：$arr['wrapper']['option'] = $value 。 默认是一个空数组。
     * @param array $params 必须是 $arr['parameter'] = $value 格式的关联数组。请参考 context parameters 里的标准资源流参数列表。
     * @return resource
     */
    public static function stream_context_create( array $option = [], array $params = [] )
    {
        return stream_context_create(...func_get_args());
    }


    /**
     * 对资源流、数据包或者上下文设置参数
     *
     * 还有一种传参：  stream_context_set_option( resource $stream_or_context, array $options) : bool
     *
     * 给指定的上下文设置参数。参数 value 是设置 wrapper 的 option 参数的值。
     *
     * @param resource $stream_or_context 需要添加参数的资源流或者上下文。
     * @param string $wrapper
     * @param string $option 添加给默认的上下文的参数。options 必须是一个 $arr['wrapper']['option'] = $value 格式二维关联数组 。请参考 context options and parameters 查看资源流参数列表。
     * @param mixed $value
     * @return bool
     */
    public static function stream_context_set_option( resource $stream_or_context, string $wrapper, string $option = null, $value = null) : bool
    {
        return stream_context_set_option( ...func_get_args());
    }


    /**
     *  获取资源流/数据包/上下文的参数
     *
     * @param resource $stream_or_context 获取参数信息的 stream 或者 context 。
     * @return array 返回指定资源流或者上下文的数组参数。
     */
    public static function  stream_context_get_options( resource $stream_or_context) : array
    {
        return stream_context_get_options( $stream_or_context);
    }


    /**
     * 设置流/包装器/上下文的参数
     * 在指定的上下文中设置参数。
     *
     * Supported parameters
     * Parameters             Purpose
     * notification           每当流触发通知时要调用的用户定义回调函数的名称。仅支持 http:// 和 ftp:// 流包装器。
     * options                Array of options as in context options andparameters. 上下文选项和参数中的选项数组。
     *
     * @param resource $stream_or_context 也要应用参数的流或上下文。
     * @param array $params 要设置的参数数组。应该是结构的关联数组：$params['paramname'] = "paramvalue";。
     * @return bool
     */
    public static function stream_context_set_params( resource $stream_or_context, array $params) : bool
    {
        return stream_context_set_params( $stream_or_context,  $params);
    }



    /**
     * 从上下文中检索参数
     * 从流或上下文中检索参数和选项信息。
     *
     * @param resource $stream_or_context 流资源或上下文资源
     * @return array 返回一个包含所有上下文选项和参数的关联数组。
     */
    public static function stream_context_get_params( resource $stream_or_context) : array
    {
        return stream_context_get_params( $stream_or_context);
    }


    /**
     * 将数据从一个流复制到另一个流
     * 从源中的当前位置（或从偏移位置，如果指定）到 dest，复制最多 maxlength 个字节的数据。 如果未指定 maxlength，则将复制源中的所有剩余内容。
     *
     * @param resource $source 源流
     * @param resource $dest 目标流
     * @param int $maxlength 要复制的最大字节数
     * @param int $offset 开始复制数据的偏移量
     * @return int|false
     */
    public static function stream_copy_to_stream( resource $source, resource $dest, int $maxlength = -1, int $offset = 0)
    {
        return stream_copy_to_stream(  $source, $dest, $maxlength = -1, $offset = 0);
    }




}












