<?php
/**
 * SessionHandler  implements SessionHandlerInterface , SessionIdInterface
 *
 *
 * SessionHandler 是一个特殊的类，可以通过继承来暴露当前PHP 内部会话保存处理程序。有七个方法包装了七个内部会话保存处理程序回调（open、close、read、write、destroy、gc 和create_sid）
 * 默认情况下，此类将包装由 session.save_handlerconfiguration 指令定义的任何内部保存处理程序，默认情况下通常是文件。
 * 其他内部会话保存处理程序由 PHPextensions 提供，例如 SQLite（作为 sqlite）、Memcache（作为 memcache）和 Memcached（作为 memcached）。
 *
 * SessionHandler 包装了当前的内部保存处理程序方法，
 * 例如，这允许您拦截 read 和 writemethods 以加密/解密会话数据，然后将结果传递给父类或从父类传递结果。或者，可以选择完全覆盖像垃圾收集回调 gc 这样的方法。
 * 请注意，此类的回调方法旨在由 PHP 内部调用，而不是从用户空间代码中调用。
 */

namespace HappyLin\OldPlugin\SingleClass\Network\Session;

use SessionHandler as SH;

class SessionHandler extends SH{


    public function __construct()
    {

    }

    /**
     * 关闭当前会话。 此函数在关闭会话时自动执行，或通过 session_write_close() 显式执行。
     *
     * 此方法包装了 session.save_handler ini 设置中定义的内部 PHP 保存处理程序，该设置是在 session_set_save_handler() 激活此处理程序之前设置的。
     * @return bool
     */
    public function close(): bool
    {
        return parent::close();
    }


    /**
     * 生成并返回一个新的会话 ID。
     *
     * @return string
     */
    public function create_sid(): string
    {
        return parent::create_sid();
    }


    /**
     * 销毁会话。 由 session_regenerate_id()（$destroy = TRUE）、session_destroy() 和 session_decode() 失败时调用。
     * @param string $session_id 正在销毁的会话 ID。
     * @return bool 会话存储的返回值（通常成功返回 0，失败返回 1）。
     */
    public function destroy(string $session_id): bool
    {
        return parent::destroy($session_id);
    }


    /**
     * 清理过期的会话。 由 session_start() 调用，基于 session.gc_divisor、session.gc_probability 和 session.gc_maxlifetime 设置。
     * @param int $max_lifetime 在最后 maxlifetime 秒内未更新的会话将被删除。
     * @return bool 会话存储的返回值（通常成功返回 0，失败返回 1）。
     */
    public function gc($max_lifetime): bool
    {
        return parent::gc($max_lifetime);
    }



    /**
     * 重新初始化现有会话，或创建一个新会话。 在会话开始或调用 session_start() 时调用。
     *
     * @param string $path 存储/检索会话的路径。
     * @param string $name 会话名称。
     * @return bool 会话存储的返回值（通常成功返回 0，失败返回 1）。
     */
    public function open($path, $name): bool
    {
        return parent::open($path, $name);
    }


    /**
     * 从会话存储中读取会话数据，并返回结果。在会话开始后或调用 session_start() 时立即调用。请注意，在调用此方法之前，会调用 SessionHandlerInterface::open()。
     *
     * 该方法在会话开始时由 PHP 自己调用。该方法应通过提供的会话 ID 从存储中检索会话数据。 此方法返回的字符串必须采用与最初传递给 SessionHandlerInterface::write() 时相同的序列化格式，如果未找到该记录，则返回一个空字符串。
     *
     * 该方法返回的数据将在 PHP 内部使用 session.serialize_handler 中指定的反序列化方法进行解码。结果数据将用于填充 $_SESSION 超全局变量。
     *
     * 请注意，序列化方案与 unserialize() 不同，可以通过 session_decode() 访问。
     *
     * @param string $session_id
     * @return string 返回读取数据的编码字符串。 如果没有读取任何内容，它必须返回一个空字符串。 请注意，此值在内部返回给 PHP 进行处理。
     */
    public function read($session_id): string
    {
        return parent::read($session_id);
    }

    /**
     * 将会话数据写入会话存储。 由 session_write_close() 调用，当 session_register_shutdown() 失败时，或在正常关闭期间。注意： SessionHandlerInterface::close() 在此函数后立即调用。
     * 当会话准备好保存和关闭时，PHP 将调用此方法。 它将 $_SESSION 超全局变量中的会话数据编码为序列化字符串，并将其与会话 ID 一起传递给此方法进行存储。 使用的序列化方法在 session.serialize_handler 设置中指定。
     *
     * 请注意，除非 session_write_close() 明确调用，否则该方法通常在输出缓冲区关闭后由 PHP 调用
     *
     * @param string $session_id 会话标识。
     * @param string $data 编码的会话数据。 此数据是 PHP 在内部将 $_SESSION 超全局变量编码为序列化字符串并将其作为此参数传递的结果。 请注意会话使用另一种序列化方法。
     * @return bool
     */
    public function write($session_id, $data): bool
    {
        return parent::write($session_id, $data);
    }


}

