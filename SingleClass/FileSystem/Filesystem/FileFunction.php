<?php

namespace HappyLin\OldPlugin\SingleClass\FileSystem\Filesystem;



class FileFunction{




    /** ····································· 文件夹信息 ············································· */



    /**
     * 返回一个目录的磁盘总大小
     * 给出一个包含有一个目录的字符串，本函数将根据相应的文件系统或磁盘分区返回所有的字节数。
     *
     * 本函数返回的是该目录所在的磁盘分区的总大小，因此在给出同一个磁盘分区的不同目录作为参数所得到的结果完全相同。在 Unix 和 Windows 200x/XP 中都支持将一个磁盘分区加载为一个子目录，这时正确使用本函数就很有意义。
     *
     * @param string $directory
     * @return float
     */
    public static function disk_total_space( string $directory) : float
    {
        return disk_total_space( $directory);
    }


    /**
     * 返回目录中的可用空间
     * 给出一个包含有一个目录的字符串，本函数将根据相应的文件系统或磁盘分区返回可用的字节数。
     *
     * Note: 如果指定了文件名而不是文件目录，这个函数的行为将并不统一，会因操作系统和 PHP 版本而异。
     *
     * @param string $directory 文件系统目录或者磁盘分区。
     * @return float 以浮点返回可用的字节数， 或者在失败时返回 FALSE。
     */
    public static function disk_free_space( string $directory) : float
    {
        return disk_free_space( $directory);
    }





    /** ····································· 文件操作 ············································· */


    /**
     * 尝试新建一个由 pathname 指定的目录
     *
     * Note:mode 在 Windows 下被忽略。
     *
     * @param string $pathname 目录的路径。
     * @param int $mode  默认的 mode 是 0777，意味着最大可能的访问权。有关 mode 的更多信息请阅读 chmod() 页面。
     * @param bool $recursive 允许递归创建由 pathname 所指定的多级嵌套目录。
     * @param resource $context Note: 在 PHP 5.0.0 中增加了对上下文（Context）的支持。有关上下文（Context）的说明参见 Streams。
     * @return bool
     */
    public static function mkdir( string $pathname, int $mode = 0777, bool $recursive = FALSE, resource $context = null ) : bool
    {
        return mkdir(...func_get_args());
    }


    /**
     * 删除目录
     * @param string $dirname 目录的路径。
     * @param resource $context
     * @return bool
     */
    public static function rmdir( string $dirname, resource $context = null) : bool
    {
        return rmdir(...func_get_args());
    }

    /**
     * 重命名一个文件或目录
     * 尝试把 oldname 重命名为 newname，必要时会在不同目录间移动。如果重命名文件时 newname 已经存在，将会覆盖掉它。如果重命名文件夹时 newname 已经存在，本函数将导致一个警告。
     *
     * Note: 用于 oldname 中的封装协议必须和用于 newname 中的相匹配。
     *
     * @param string $oldname
     * @param string $newname 新的名字。
     * @param resource $context  PHP 5.0.0 中增加了对上下文（Context）的支持。有关上下文（Context）的说明参见 Streams。
     * @return bool
     */
    public static function rename( string $oldname, string $newname, resource $context = null ) : bool
    {
        return rename(...func_get_args());
    }



    /**
     * 建立一个具有唯一文件名的文件
     * Note:Windows 仅使用前缀的前三个字符。
     *
     * @param string $dir 将创建临时文件名的目录
     * @param string $prefix 产生临时文件的前缀。
     * @return string 返回新的临时文件名，出错返回 FALSE。
     */
    public static function tempnam( string $dir, string $prefix) : string
    {
        return tempnam( $dir,  $prefix);
    }




    /**
     * 改变文件所属的组
     * 尝试将文件 filename 所属的组改成 group（通过组名或组 ID 指定）。
     * 只有超级用户可以任意修改文件的组，其它用户可能只能将文件的组改成该用户自己所在的组。
     *
     * @param string $filename 文件的路径。
     * @param mixed $group 组的名称或数字。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function chgrp( string $filename, $group) : bool
    {

        if (!strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return false;
        }

        return chgrp( $filename, $group);
    }

    /**
     * 尝试将 filename 所指定文件的模式改成 mode 所给定的。
     *
     * 注意 mode 不会被自动当成八进制数值，而且也不能用字符串（例如 "g+w"）。要确保正确操作，需要给 mode 前面加上 0：
     *
     * @param string $filename 文件的路径
     * @param int $mode  参数包含三个八进制数按顺序分别指定了所有者、所有者所在的组以及所有人的访问限制。 数字 1 表示使文件可执行，数字 2 表示使文件可写，数字 4 表示使文件可读。
     * @return bool
     */
    public static function chmod( string $filename, int $mode) : bool
    {
        if (!strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return false;
        }
        return chmod($filename, $mode);
    }

    /**
     * 改变文件的所有者
     * @param string $filename 文件路径。
     * @param mixed $user 用户名或数字。
     * @return bool
     */
    public static function chown( string $filename, $user) : bool
    {
        if (!strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return false;
        }
        return chown( $filename, $user);
    }

    /**
     * 设定文件的访问和修改时间
     *
     * @param string $filename
     * @param int $time
     * @param int $atime
     * @return bool
     */
    public static function touch( string $filename, int $time = null, int $atime = null) : bool
    {
        return touch(...func_get_args());
    }

    /**
     * 建立一个硬连接
     * @param string $target 要链接的目标。
     * @param string $link 链接的名称。
     * @return bool
     */
    public static function link( string $target, string $link) : bool
    {
        return link( $target, $link);
    }



    /**
     * 建立符号连接
     * @param string $target  连接的目标。
     * @param string $link 连接的名称。
     * @return bool
     */
    public static function symlink( string $target, string $link) : bool
    {
        return symlink( $target, $link) ;
    }



    /**
     * 修改符号链接的所有组
     * 尝试修改符号链接 filename 的所有组 group
     * 只有超级用户可以任意修改符号链接的所有组;其他用户可能需要有修改目标组的权限才能修改至目标所有组。
     *
     * Note: 此函数未在 Windows 平台下实现。
     *
     * @param string $filename 符号链接路径
     * @param mixed $group 所有组的名字或者编号
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function lchgrp( string $filename, $group) : bool
    {
        if (!strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return false;
        }
        return lchgrp( $filename, $group);
    }


    /**
     * 修改符号链接的所有者
     * 只有超级用户任意修改符号链接的所有者。
     *
     * Note: 此函数未在 Windows 平台下实现。
     *
     * @param string $filename 文件路径。
     * @param mixed $user 所有者名称或编号
     * @return bool
     */
    public static function lchown( $filename, $user) : bool
    {
        if (!strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return false;
        }
        return lchown( $filename, $user);
    }




    /**
     * 将文件从 source 拷贝到 dest。
     * 如果要移动文件的话，请使用 rename() 函数。
     *
     * @param string $source 源文件路径。
     * @param string $dest 目标路径。如果 dest 是一个 URL，则如果封装协议不支持覆盖已有的文件时拷贝操作会失败。
     * @param resource $context 使用 stream_context_create() 创建的有效上下文资源。
     * @return bool
     */
    public static function copy( string $source, string $dest, resource $context = null) : bool
    {
        return copy(...func_get_args());
    }


    /**
     * 删除文件
     * 删除 filename。和 Unix C 的 unlink() 函数相似。发生错误时会产生一个 E_WARNING 级别的错误。
     *
     * @param string $filename
     * @param resource $context
     * @return bool
     */
    public static function unlink( string $filename, resource $context = null) : bool
    {
        return unlink(...func_get_args());
    }


    /**
     * 取得文件的上次访问时间
     *
     * @param string $filename
     * @return int 返回文件上次被访问的时间， 或者在失败时返回 FALSE。时间以 Unix 时间戳的方式返回。
     */
    public static function fileatime( string $filename) : int
    {
        return fileatime( $filename);
    }


    /**
     * 取得文件的 inode 修改时间
     *
     * @param string $filename
     * @return int 返回文件上次 inode 被修改的时间， 或者在失败时返回 FALSE。时间以 Unix 时间戳的方式返回。
     */
    public static function filectime( string $filename) : int
    {
        return filectime( $filename);
    }




    /**
     * 返回文件路径的信息
     * 返回一个关联数组包含有 path 的信息。返回关联数组还是字符串取决于 options。
     *
     * Note: 如果路径没有扩展名，则不返回扩展名元素
     *
     * @param string $path 要解析的路径。
     * @param int|string $options 如果指定了，将会返回指定元素；它们包括：PATHINFO_DIRNAME，PATHINFO_BASENAME 和 PATHINFO_EXTENSION 或 PATHINFO_FILENAME。如果没有指定 options 默认是返回全部的单元。
     * @return mixed 如果没有传入 options ，将会返回包括以下单元的数组 array：dirname，basename 和 extension（如果有），以 及filename。
     */
    public static function pathinfo( string $path, int $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME )
    {
        return pathinfo(...func_get_args());
    }



    /**
     * 返回路径中的目录部分
     * 给出一个包含有指向一个文件的全路径的字符串，本函数返回去掉文件名后的目录名，且目录深度为 levels 级。
     *
     * @param string $path 一个路径。
     * @param int $levels 要向上的父目录数量。整型，必须大于 0。
     * @return string
     */
    public static function dirname( string $path, int $levels = 1) : string
    {
        return dirname(...func_get_args());
    }



    /**
     * 返回路径中的文件名部分
     *
     * @param string $path 一个路径。 在 Windows 中，斜线（/）和反斜线（\）都可以用作目录分隔符。在其它环境下是斜线（/）。
     * @param string|null $suffix 如果文件名是以 suffix 结束的，那这一部分也会被去掉。
     * @return string 返回 path 的基本的文件名。
     */
    public static function basename( string $path, string $suffix = null) : string
    {
        return basename( $path, $suffix);
    }


    /**
     * 用模式匹配文件名
     * 检查传入的 string 是否匹配给出的 shell 统配符 pattern。
     *
     * 普通用户可能习惯于 shell 模式或者至少其中最简单的形式 '?' 和 '*' 通配符，因此使用 fnmatch() 来代替 preg_match() 来进行前端搜索表达式输入对于非程序员用户更加方便。
     *
     * $flags
     *  FNM_NOESCAPE 禁用反斜杠转义。
     *  FNM_PATHNAME 字符串中的斜杠仅匹配给定模式中的斜杠。
     *  FNM_PERIOD 字符串中的前导句点必须与给定模式中的句点完全匹配。
     *  FNM_CASEFOLD 无壳匹配。 GNU 扩展的一部分。
     *
     * @param string $pattern shell 统配符。
     * @param string $string 要检查的字符串。此函数对于文件名尤其有用，但也可以用于普通的字符串。 FNM_NOESCAPE FNM_PATHNAME FNM_PERIOD FNM_CASEFOLD
     * @param int $flags flags 的值可以是以下标志的任意组合，并使用二元 OR (|) 运算符连接。
     * @return bool
     */
    public static function fnmatch( string $pattern, string $string, int $flags = 0) : bool
    {
        return fnmatch(...func_get_args());
    }


    /**
     * 寻找与模式匹配的文件路径
     * 函数依照 libc glob() 函数使用的规则寻找所有与 pattern 匹配的文件路径，类似于一般 shells 所用的规则一样。
     *
     * pattern
     *  特殊字符：
     *  *         - 匹配零个或多个字符。
     *  ?         - 只匹配单个字符（任意字符）。
     *  [...]     - 匹配一组字符中的一个字符。如果第一个字符是 !，则为否定模式，即匹配不在这组字符中的任意字符。
     *  \         - 只要没有使用 GLOB_NOESCAPE 标记，该字符会转义后面的字符。
     *
     * flags
     *  有效标记有：
     *  GLOB_MARK       - 在每个返回的项目中加一个斜线
     *  GLOB_NOSORT     - 按照文件在目录中出现的原始顺序返回（不排序）
     *  GLOB_NOCHECK    - 如果没有文件匹配则返回用于搜索的模式
     *  GLOB_NOESCAPE   - 反斜线不转义元字符
     *  GLOB_BRACE      - 扩充 {a,b,c} 来匹配 'a'，'b' 或 'c'
     *  GLOB_ONLYDIR    - 仅返回与模式匹配的目录项
     *  GLOB_ERR        - 停止并读取错误信息（比如说不可读的目录），默认的情况下忽略所有错误
     *
     * @param string $pattern 匹配模式（pattern）。不进行缩写扩展或参数替代。
     * @param int $flags 有效标记
     * @return array | false 返回包含有匹配文件和目录的数组，没有匹配文件时返回空数组，出错返回 FALSE。
     */
    public static function glob( string $pattern, int $flags = 0)
    {
        return glob( $pattern, $flags = 0);
    }



    /**
     * 将一个字符串写入文件
     * 和依次调用 fopen()，fwrite() 以及 fclose() 功能一样。
     * 如果文件名不存在，则创建该文件。否则，除非设置了 FILE_APPEND 标志，否则将覆盖现有文件。
     *
     *
     * $flags
     *  FILE_USE_INCLUDE_PATH  在 include 目录里搜索 filename。更多信息可参见 include_path。
     *  FILE_APPEND  如果文件 filename 已经存在，追加数据而不是覆盖。
     *  LOCK_EX  在写入时获得一个独占锁。
     *
     * @param string $filename 要被写入数据的文件名。
     * @param mixed $data 要写入的数据。类型可以是 string，array 或者是 stream 资源。如果 data 指定为 stream 资源，这里 stream 中所保存的缓存数据将被写入到指定文件中，这种用法就相似于使用 stream_copy_to_stream() 函数。
     * @param int $flags FILE_USE_INCLUDE_PATH  FILE_APPEND  LOCK_EX
     * @param resource $context 一个 context 资源。
     * @return int
     */
    public static function file_put_contents( string $filename, mixed $data, int $flags = 0, $context ) : int
    {
        return file_put_contents(...func_get_args());
    }



    /**
     * 将整个文件读入一个字符串
     * 和 file() 一样，只除了 file_get_contents() 把文件读入一个字符串。将在参数 offset 所指定的位置开始读取长度为 maxlen 的内容。如果失败，file_get_contents() 将返回 FALSE。
     * file_get_contents() 函数是用来将文件的内容读入到一个字符串中的首选方法。如果操作系统支持还会使用内存映射技术来增强性能。
     *
     * @param string $filename  要读取的文件的名称
     * @param bool $use_include_path FILE_USE_INCLUDE_PATH 可用于触发包含路径搜索
     * @param resource $context 使用 stream_context_create() 创建的有效上下文资源。 如果你不需要自定义上下文，可以用 NULL 来忽悠。
     * @param int $offset 在原始流上开始读取的偏移量。远程文件不支持搜索（偏移量）。尝试在非本地文件上搜索可能适用于小偏移量，但这是不可预测的，因为它适用于缓冲流。
     * @param int $maxlen 读取数据的最大长度。 默认是读取直到到达文件末尾。 请注意，此参数应用于过滤器处理的流。
     * @return string
     */
    public static function file_get_contents( string $filename, bool $use_include_path = false, $context = null  , int $offset = -1, int $maxlen = null ) : string
    {
        return file_get_contents(...func_get_args());
    }


    /**
     * 把整个文件读入一个数组中
     *
     * Note: 结果数组中的每一行都将包含行尾，除非使用了 FILE_IGNORE_NEW_LINES，所以如果你不想出现行尾，你仍然需要使用 rtrim()。
     * @param string $filename 文件的路径。
     * @param int $flags 一个或多个常量：  FILE_USE_INCLUDE_PATH 在 include_path 中查找文件。 FILE_IGNORE_NEW_LINES 在数组每个元素的末尾不要添加换行符.   FILE_SKIP_EMPTY_LINES  跳过空行
     * @param resource $context
     * @return array | false 以数组形式返回文件。 数组的每个元素对应于文件中的一行，换行符仍然附加。 失败时，file() 返回 FALSE。
     */
    public static function file( string $filename, int $flags = 0, $context)
    {
        return file(...func_get_args());
    }

    /**
     * 清除文件状态缓存
     * 如果调用 file_exists() 来检查不存在的文件，在该文件没有被创建之前，它都会返回 FALSE。如果该文件被创建了，就算以后被删除，它都会返回 TRUE; 函数 unlink() 会自动清除该缓存.
     *
     * 当使用 stat()，lstat() 或者任何列在受影响函数表（见下面）中的函数时，PHP 将缓存这些函数的返回信息以提供更快的性能。然而在某些情况下，你可能想清除被缓存的信息。
     * Note: 本函数缓存特定文件名的信息，因此只在对同一个文件名进行多次操作并且需要该文件信息不被缓存时才需要调用 clearstatcache()。
     *
     * 受影响的函数包括 stat()， lstat()， file_exists()， is_writable()， is_readable()， is_executable()， is_file()， is_dir()， is_link()， filectime()， fileatime()， filemtime()， fileinode()， filegroup()， fileowner()， filesize()， filetype() 和 fileperms()。
     *
     * @param bool $clear_realpath_cache 是否清除真实路径缓存
     * @param string $filename 清除文件名指定的文件的真实路径缓存; 只在 clear_realpath_cache 为 TRUE 时启用
     */
    public static function clearstatcache(bool $clear_realpath_cache = false, string $filename = null) : void
    {
        clearstatcache(...func_get_args());
    }



    /** ····································· 文件handle操作(内容) ············································· */





    /**
     * 打开文件或者 URL
     *
     * $mode
     * 'r' 只读方式打开，将文件指针指向文件头。
     * 'r+' 读写方式打开，将文件指针指向文件头。
     * 'w' 写入方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
     * 'w+' 读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
     * 'a' 写入方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
     * 'a+' 读写方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
     * 'x' 创建并以写入方式打开，将文件指针指向文件头。如果文件已存在，则 fopen() 调用失败并返回 FALSE，并生成一条 E_WARNING 级别的错误信息。如果文件不存在则尝试创建之。这和给底层的 open(2) 系统调用指定 O_EXCL|O_CREAT 标记是等价的。
     * 'x+' 创建并以读写方式打开，其他的行为和 'x' 一样。
     * 'c' Open the file for writing only. If the file does not exist, it iscreated. If it exists, it is neither truncated (as opposed to 'w'), nor the call to this function fails (as isthe case with 'x'). The file pointer ispositioned on the beginning of the file. This may be useful if it'sdesired to get an advisory lock (see flock())before attempting to modify the file, as using 'w' could truncate the file before the lockwas obtained (if truncation is desired, ftruncate() can be used after the lock isrequested).
     * 'c+' Open the file for reading and writing; otherwise it has the samebehavior as 'c'.
     *
     *
     * Note:为移植性考虑，强烈建议在用 fopen() 打开文件时总是使用 'b' 标记。
     *
     *
     * @param string $filename 本地文件，将尝试在该文件上打开一个流。如果激活了 open_basedir 则会应用进一步的限制;如果 filename 是 "scheme://..." 的格式，则被当成一个 URL，如果是一个已注册的协议，而该协议被注册为一个网络 URL，PHP 将检查并确认 allow_url_fopen 已被激活。
     * @param string $mode 参数指定了所要求到该流的访问类型
     * @param bool $use_include_path 如果也需要在 include_path 中搜寻文件的话，可以将可选的第三个参数 use_include_path 设为 '1' 或 TRUE。
     * @param resource|null $context
     * @return resource
     */
    public static function fopen( string $filename, string $mode, bool $use_include_path = false,  $context = null )
    {
        return fopen(...func_get_args());
    }

    /**
     * 通过已打开的文件指针取得文件信息
     * 本函数和 stat() 函数相似，除了它是作用于已打开的文件指针而不是文件名。
     * @param resource $handle
     * @return array 返回一个数组具有该文件的统计信息，该数组的格式详细说明于手册中 stat() 页面里。
     */
    public static function fstat( $handle) : array
    {
        return fstat( $handle);
    }


    /**
     * 写入文件（可安全用于二进制文件）
     * 把 string 的内容写入文件指针 handle 处。
     *
     * Note:在区分二进制文件和文本文件的系统上（如 Windows）打开文件时，fopen() 函数的 mode 参数要加上 'b'。
     * Note:如果句柄是 fopen()ed inappend 模式，则 fwrite()s 是原子的（除非字符串的大小超过文件系统的块大小，
     *
     *
     * @param resource $handle 文件系统指针，是典型地由 fopen() 创建的 resource(资源)。
     * @param string $string 要写入的字符串。
     * @param int $length 如果指定了 length，当写入了 length 个字节或者写完了 string 以后，写入就会停止，视乎先碰到哪种情况。
     * @return int | false fwrite() 返回写入的字符数，出现错误时则返回 FALSE 。
     */
    public static function fwrite( $handle, string $string, int $length)
    {
        return fwrite( ...func_get_args());
    }



    /**
     * 倒回文件指针的位置
     * 将 handle 的文件位置指针设为文件流的开头。
     *
     * Note: 如果将文件以附加（"a" 或者 "a+"）模式打开，写入文件的任何数据总是会被附加在后面，不管文件指针的位置。
     *
     * @param resource $handle
     * @return bool
     */
    public static function rewind( $handle) : bool
    {
        return rewind( $handle);
    }



    /**
     * 返回由 handle 指定的文件指针的位置，也就是文件流中的偏移量。
     * @param resource $handle
     * @return int | false 以整数形式返回句柄引用的文件指针的位置； 即，它在文件流中的偏移量。如果出错，返回 FALSE。
     */
    public static function ftell(  $handle) : int
    {
        return ftell( $handle);
    }



    /**
     * 在文件指针中定位
     * 在与 handle 关联的文件中设定文件指针位置。新位置从文件头开始以字节数度量，是以 whence 指定的位置加上 offset。
     *
     * 一般情况下，允许查找越过文件尾； 如果数据随后被写入，则在文件末尾和搜索位置之间的任何未写入区域中的读取将产生值为 0 的字节。但是，某些流可能不支持这种行为，尤其是当它们具有底层固定大小的存储时。
     *
     * whence
     * whence values are:
     * •SEEK_SET - 设定位置等于 offset 字节。
     * •SEEK_CUR - 设定位置为当前位置加上 offset。
     * •SEEK_END - 设定位置为文件尾加上 offset。
     *
     * @param resource $handle
     * @param int $offset 要移动到文件尾之前的位置，需要给 offset 传递一个负值，并设置 whence 为 SEEK_END。
     * @param int $whence SEEK_SET - 设定位置等于 offset 字节;   SEEK_CUR - 设定位置为当前位置加上 offset。  SEEK_END - 设定位置为文件尾加上 offset。
     * @return int 成功则返回 0；否则返回 -1。注意移动到 EOF 之后的位置不算错误。
     */
    public static function fseek( $handle, int $offset, int $whence = SEEK_SET ) : int
    {
        return fseek( $handle, $offset, $whence );
    }


    /**
     * 从文件句柄中获取一个字符。
     *
     * @param resource $handle
     * @return string | false 返回一个包含有一个字符的字符串，该字符从 handle 指向的文件中得到。碰到 EOF 则返回 FALSE。
     */
    public static function fgetc( $handle)
    {
        return fgetc( $handle);
    }


    /**
     * 从文件指针中读取一行。
     *
     * @param resource $handle 文件指针必须是有效的，必须指向由 fopen() 或 fsockopen() 成功打开的文件(并还未由 fclose() 关闭)。
     * @param int $length 从 handle 指向的文件中读取一行并返回长度最多为 length - 1 字节的字符串。碰到换行符（包括在返回值中）、EOF 或者已经读取了 length - 1 字节后停止（看先碰到那一种情况）。如果没有指定 length，则默认为 1K，或者说 1024 字节。
     * @return string | false 从指针 handle 指向的文件中读取了 length - 1 字节后返回字符串。如果文件指针中没有更多的数据了则返回 FALSE。
     */
    public static function fgets(  $handle, int $length)
    {
        return fgets(...func_get_args());
    }


    /**
     * 从文件中格式化输入
     * fscanf() 函数和 sscanf() 相似，但是它从与 handle 关联的文件中接受输入并根据指定的 format（定义于 sprintf() 的文档中）来解释输入。
     * 格式字符串中的任何空白会与输入流中的任何空白匹配。这意味着甚至格式字符串中的制表符 \t 也会与输入流中的一个空格字符匹配。
     * 每次调用 fscanf() 都会从文件中读取一行。
     *
     * $format
     *  格式字符串由零个或多个指令组成：直接复制到结果的普通字符（不包括%）和转换规范，每个字符都会获取自己的参数。
     *  转换规范遵循以下原型：%[argnum$][flags][width][.precision]说明符。
     *
     *  Argnum
     *  后跟
     *      $ 美元符号的整数，用于指定转换中要处理的数字参数。      例如： %2$s ；第二个字符串参数；
     *      - 在给定的字段宽度内左对齐；右对齐是默认值             例如： %2$-8s; 第二个字符串参数, 左对齐占八个字符；
     *      + 用加号 + 前缀正数； 默认只有负号前缀为负号。         例如： %1$-+04d；第一个字符串参数, 左对齐占四个字符；正整数加正号；
     *      （space）空格用空格填充结果。这是默认设置。
     *      0 只用零填充左边的数字。使用 s 说明符，这也可以用零填充右边。 例如： %04d ；'0004';    %4d ；'   4';
     *      '(char) 用字符 (char) 填充结果。                    例如：%2$'a-8s;  第二个字符串参数, 左对齐，用 a 填充空格
     *
     *  Width
     *      一个整数，表示此转换应产生多少个字符（最少）。
     *
     *  Precision精确度
     *      一段时间 。 后跟一个整数，其含义取决于说明符：                        例如： %1$'0-+4.2f 第一个字符串参数, 左对齐占四个字符；正整数加正号；整数四字符，小数 2 字符
     *      对于 e、E、f 和 Fspecifiers：这是小数点后要打印的位数（默认为 6）。
     *      对于 g 和 Gspecifiers：这是要打印的最大有效数字数。
     *      对于 s 说明符：它充当截止点，设置字符串的最大字符数限制。              列如： %2$'0-8.2s 第二个字符串参数, 左对齐，用 0 填充空格； 占八字符， 限制参数展示 2 字符； 其余 0 填充；
     *
     *      注意：如果指定的周期没有明确的精度值，则假定为 0。
     *      注意：尝试使用大于 PHP_INT_MAX 的位置说明符将生成警告。
     *
     *
     *      %   文字百分比字符。不需要参数。
     *      b   该参数被视为一个整数并表示为一个二进制数。
     *      c   该参数被视为一个整数，并作为带有该 ASCII 的字符表示。
     *      d   参数被视为整数并表示为（有符号的）十进制数。
     *      e   该参数被视为科学记数法（例如 1.2e+2）。自 PHP 5.2.1 起，精度说明符代表小数点后的位数。在早期版本中，它被视为有效数字的数量（少一位）。
     *      E   类似于 e 说明符，但使用大写字母（例如 1.2E+2）。
     *      f   该参数被视为一个浮点数并呈现为一个浮点数（语言环境感知）。
     *      F   该参数被视为浮点数并表示为浮点数（非语言环境感知）。自 PHP 5.0.3 起可用。
     *      g   一般格式。
     *          如果非零，则 P 等于精度，如果精度被省略，则为 6，如果精度为零，则为 1。那么，如果样式 E 的转换将具有 X 的指数：
     *          如果 P > X ≥ ?4，则转换为风格 f 和精度 P ? (X + 1)。否则，转换是样式 e 和精度 P ？ 1.
     *      G   与 g 说明符类似，但使用 E 和 f。
     *      o   该参数被视为一个整数并表示为一个八进制数。
     *      s   参数被处理并显示为字符串。
     *      u   参数被视为整数，并表示为无符号十进制数。
     *      x   该参数被视为一个整数，并以十六进制数（带小写字母）的形式表示。
     *      X   参数被视为整数，并以十六进制数（大写字母）表示。
     *
     *      警告 c 类型说明符忽略填充和宽度
     *      警告 尝试将字符串和宽度说明符与每个字符需要超过一个字节的字符集结合使用可能会导致意外结果
     *
     * string   s
     * integer  d, u, c, o, x, X, b
     * double   g, G, e, E, f, F
     *
     * @param resource $handle
     * @param string $format 参数格式是 sprintf() 文档中所描述的格式。
     * @param mixed ...$vars 可选的赋值。
     * @return mixed 如果只给此函数传递了两个参数，解析后的值会被作为数组返回。否则，如果提供了可选参数，此函数将返回被赋值的数目。可选参数必须用引用传递。
     */
    public static function fscanf( $handle, string $format, &...$vars )
    {
        return fscanf( $handle, $format,  ...$vars);
    }



    /**
     *  从文件指针中读取一行并过滤掉 HTML 标记  已废弃
     *
     * @param resource $handle
     * @param int $length 取回该长度的数据。
     * @param string $allowable_tags 可以用可选的第三个参数指定哪些标记不被去掉。
     * @return string | false 从 handle 指向的文件中大读取 length - 1 个字节的字符，并过滤了所有的 HTML 和 PHP 代码。
     */
    public static function  fgetss( $handle, int $length = null, string $allowable_tags = null )
    {
        return fgetss(...func_get_args());
    }


    /**
     * 轻便的咨询文件锁定
     * PHP 支持以咨询方式（也就是说所有访问程序必须使用同一方式锁定, 否则它不会工作）锁定全部文件的一种轻便方法。默认情况下，这个函数会阻塞到获取锁；这可以通过下面文档中 LOCK_NB 选项来控制（在非 Windows 平台上）。
     *
     * Note: 由于 flock() 需要一个文件指针， 因此可能不得不用一个特殊的锁定文件来保护打算通过写模式打开的文件的访问（在 fopen() 函数中加入 "w" 或 "w+"）。
     * Note: 只能用于 fopen() 为本地文件返回的文件指针，或指向实现 streamWrapper::stream_lock() 方法的用户空间流的文件指针。
     *
     * @param resource $handle
     * @param int $operation LOCK_SH取得共享锁定（读取的程序）。 LOCK_EX 取得独占锁定（写入的程序。 LOCK_UN 释放锁定（无论共享或独占）。LOCK_NB 如果不希望 flock() 在锁定时堵塞；则加上 LOCK_NBLOCK_NB（Windows 上还不支持
     * @param int $wouldblock 如果锁定会堵塞的话（EWOULDBLOCK 错误码情况下），可选的第三个参数会被设置为 TRUE。（Windows 上不支持）
     * @return bool
     */
    public static function flock( $handle, int $operation, int &$wouldblock) : bool
    {
        return flock(...func_get_args());
    }


    /**
     * 读取文件（可安全用于二进制文件）
     *
     * Warning 当从任何不是普通本地文件读取时，例如在读取从远程文件或 popen() 以及 fsockopen() 返回的流时，读取会在一个包可用之后停止。这意味着应该将数据收集起来合并成大块。
     *
     * fread() 从文件指针 handle 读取最多 length 个字节。该函数在遇上以下几种情况时停止读取文件：
     *  读取了 length 个字节
     *  到达了文件末尾（EOF）
     *  数据包变得可用或发生套接字超时（对于网络流）
     *  如果流被缓冲读取并且它不代表纯文件，则最多读取一次等于块大小（通常为 8192）的字节数； 根据之前缓冲的数据，返回数据的大小可能大于块大小。
     *
     * @param resource $handle
     * @param int $length
     * @return string
     */
    public static function fread( $handle, int $length) : string
    {
        return fread( $handle, $length);
    }


    /**
     * 将文件截断到给定的长度
     * 接受文件指针 handle 作为参数，并将文件大小截取为 size。
     *
     * Note: 手柄必须打开才能写入
     * Note: 如果大小大于文件，则用空字节扩展文件。如果大小小于文件，则文件将被截断为该大小。
     *
     * @param resource $handle
     * @param int $size 要截断的大小。
     * @return bool
     */
    public static function ftruncate( $handle, int $size) : bool
    {
        return ftruncate($handle, $size);
    }





    /**
     * 测试文件指针是否到了文件结束的位置
     *
     * @param resource $handle 文件指针必须是有效的，必须指向由 fopen() 或 fsockopen() 成功打开的文件(并还未由 fclose() 关闭)。
     * @return bool
     */
    public static function feof( $handle) : bool
    {
        return feof( $handle);
    }




    /**
     * 关闭一个已打开的文件指针
     * 将 handle 指向的文件关闭。
     *
     * @param resource $handle 文件指针必须有效，并且是通过 fopen() 或 fsockopen() 成功打开的。
     * @return bool
     */
    public static function fclose( $handle) : bool
    {
        return fclose( $handle);
    }









    /** ····································· 未分类函数 ············································· */

    /**
     * 将缓冲内容输出到文件
     * 本函数强制将所有缓冲的输出写入 handle 文件句柄所指向的资源。
     *
     * @param resource $handle 文件指针必须是有效的，必须指向由 fopen() 或 fsockopen() 成功打开的文件(并还未由 fclose() 关闭)。
     * @return bool
     */
    public static function fflush( $handle) : bool
    {
        return fflush( $handle);
    }


    /**
     * 将行格式化为 CSV 并写入文件指针
     * 将一行（用 fields 数组传递）格式化为 CSV 格式并写入由 handle 指定的文件。
     *
     * @param resource $handle 文件指针必须是有效的，必须指向由 fopen() 或 fsockopen() 成功打开的文件(并还未由 fclose() 关闭)。
     * @param array $fields 值的一个数组。
     * @param string $delimiter 可选的 delimiter 参数设定字段分界符（只允许一个字符）。
     * @param string $enclosure 可选的 enclosure 参数设定字段字段环绕符（只允许一个字符）。
     * @return int | false  返回写入字符串的长度， 或者在失败时返回 FALSE。
     */
    public static function fputcsv( $handle, array $fields, string $delimiter = ',', string $enclosure = '"')
    {
        return fputcsv(...func_get_args());
    }



    /**
     * 从文件指针中读入一行并解析 CSV 字段
     *
     * @param resource $handle 一个由 fopen()、popen() 或 fsockopen() 产生的有效文件指针。
     * @param int $length  必须大于 CVS 文件内最长的一行。在 PHP 5 中该参数是可选的。如果忽略（在 PHP 5.0.4 以后的版本中设为 0）该参数的话，那么长度就没有限制，不过可能会影响执行效率。
     * @param string $delimiter 设置字段分界符（只允许一个字符）。
     * @param string $enclosure 设置字段环绕符（只允许一个字符）。
     * @param string $escape 设置转义字符（只允许一个字符），默认是一个反斜杠。
     * @return array | null | false  返回包含读取字段的索引数组。 如果提供了无效的文件指针，fgetcsv() 会返回 NULL。其他错误，包括碰到文件结束时返回 FALSE，。
     */
    public static function fgetcsv( $handle, int $length = 0, string $delimiter = ',', string $enclosure = '"', string $escape = '\\' )
    {
        return fgetcsv(...func_get_args());
    }



    /**
     * 将上传的文件移动到新位置
     *
     * 本函数检查并确保由 filename 指定的文件是合法的上传文件（即通过 PHP 的 HTTP POST 上传机制所上传的）。如果文件合法，则将其移动为由 destination 指定的文件
     *
     * @param string $filename 上传的文件的文件名。
     * @param string $destination  移动文件到这个位置。
     * @return bool 如果 filename 不是合法的上传文件，不会出现任何操作，move_uploaded_file() 将返回 FALSE。如果 filename 是合法的上传文件，但出于某些原因无法移动，不会出现任何操作，move_uploaded_file() 将返回 FALSE。此外还会发出一条警告。
     */
    public static function move_uploaded_file( string $filename, string $destination) : bool
    {
        return move_uploaded_file( $filename, $destination);
    }


    /**
     * 解析一个配置文件
     * parse_ini_file() 载入一个由 filename 指定的 ini 文件，并将其中的设置作为一个联合数组返回。
     * ini 文件的结构和 php.ini 的相似。
     *
     * @param string $filename 要解析的 ini 文件的文件名。
     * @param bool $process_sections 如果将最后的 process_sections 参数设为 TRUE，将得到一个多维数组，包括了配置文件中每一节的名称和设置。process_sections 的默认值是 FALSE。
     * @param int $scanner_mode 可以是 INI_SCANNER_NORMAL（默认）或 INI_SCANNER_RAW。 如果提供了 INI_SCANNER_RAW，则不会解析选项值。
     * @return array
     */
    public static function parse_ini_file( string $filename, bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL) : array
    {
        return parse_ini_file(...func_get_args());
    }


    /**
     * 解析配置字符串
     * 返回 ini 字符串解析后的关联数组
     * ini 字符串的格式参考 php.ini
     *
     * @param string $ini ini 字符串的格式参考 php.ini
     * @param bool $process_sections 设置 process_sections 参数为 TRUE,得到一个多维数组,包含名称和设置。process_sections 默认为 FALSE
     * @param int $scanner_mode
     * @return array
     */
    public static function parse_ini_string( string $ini, bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL) : array
    {
        return parse_ini_string(...func_get_args());
    }



    /**
     *
     * 将给定的文件指针从当前的位置读取到 EOF 并把结果写到输出缓冲区。
     * @param resource $handle 文件指针必须是有效的，必须指向由 fopen() 或 fsockopen() 成功打开的文件(并还未由 fclose() 关闭)。
     * @return int | false 如果发生错误， fpassthru() 返回 FALSE。否则 fpassthru() 返回从 handle 读取并传递到输出的字符数目。
     */
    public static function fpassthru( $handle)
    {
        return fpassthru( $handle);
    }

    /**
     * 读取文件并写入到输出缓冲。
     *
     * @param string $filename 要读取的文件名。
     * @param bool $use_include_path 想要在 include_path 中搜索文件，可使用这个可选的第二个参数，设为 TRUE。
     * @param resource $context Stream 上下文（context） resource。
     * @return int | false 成功时返回从文件中读入的字节数， 或者在失败时返回 FALSE
     */
    public static function readfile( string $filename, bool $use_include_path = FALSE, resource $context = null ) : int
    {
        return readfile(...func_get_args());
    }



}

