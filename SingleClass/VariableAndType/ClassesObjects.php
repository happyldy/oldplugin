<?php
/**
 * 这些函数允许你获得类和对象实例的相关信息。你可以获取对象所属的类名，也可以是它的成员属性和方法。通过使用这些函数，你不仅可以找到对象和类的关系，也可以是它们的继承关系（例如，对象类继承自哪个类）。
 */

namespace HappyLin\OldPlugin\SingleClass\VariableAndType;


class ClassesObjects
{

    /**
     * 返回由当前脚本中已定义类的名字组成的数组。
     *
     * @return array
     */
    public static function getDeclaredClasses() : array
    {
        return get_declared_classes();
    }

    /**
     *  返回一个数组包含所有已声明的接口
     *
     * @return array 本函数返回一个数组，其内容是当前脚本中所有已声明的接口的名字。
     */
    public static function getDeclaredInterfaces() : array
    {
        return get_declared_interfaces();
    }

    /**
     * 返回所有已定义的 traits 的数组
     *
     * @return array 返回一个数组，其值包含了所有已定义的 traits 的名称。在失败的情况下返回 NULL。
     */
    public static function getDeclaredTraits()
    {
        return get_declared_traits();
    }

    /**
     * 检查类是否已定义
     *
     * @param string $class_name 类名。名字的匹配是不分区大小写的。
     * @param bool $autoload 是否默认调用 __autoload。
     * @return bool 如果由 class_name 所指的类已经定义，此函数返回 TRUE，否则返回 FALSE。
     */
    public static function classExists( string $class_name, bool $autoload = true) : bool
    {
        return class_exists($class_name, $autoload);
    }

    /**
     * 检查接口是否已被定义
     *
     * @param string $interface_name 接口名。
     * @param bool $autoload 默认是否调用 __autoload。
     * @return bool 本函数在由 interface_name 给出的接口已定义时返回 TRUE，否则返回 FALSE。
     */
    public static function interfaceExists( string $interface_name, bool $autoload = true) : bool
    {
        return interface_exists( $interface_name, $autoload);
    }

    /**
     * 检查指定的 trait 是否存在
     *
     * @param string $traitname 待检查的 trait 的名称
     * @param bool $autoload 如果尚未加载，是否使用自动加载（autoload）。
     * @return bool 如果 trait 存在返回 TRUE，不存在则返回 FALSE。发生错误的时候返回 NULL。
     */
    public static function traitExists( string $traitname, bool $autoload = true) : bool
    {
        return trait_exists( $traitname, $autoload);
    }

    /**
     * 为一个类创建别名
     * 基于用户定义的类 original 创建别名 alias。这个别名类和原有的类完全相同。
     *
     * @param string $original 原有的类。
     * @param string $alias 类的别名。
     * @param bool $autoload 如果原始类没有加载，是否使用自动加载（autoload）。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function classAlias( string $original, string $alias, bool $autoload = TRUE) : bool
    {
        return class_alias( $original, $alias, $autoload);
    }


    /**
     * 返回对象或类的父类名
     * 如果 obj 是对象，则返回对象实例 obj 所属类的父类名。
     * 如果 obj 是字符串，则返回以此字符串为名的类的父类名。
     *
     * @param mixed $obj 测试对象或类名
     * @return string 返回对象为实例的类的父类的名称或名称。如果对象没有父对象或给定的类不存在，将返回FALSE。
     */
    public static function getParentClass( $obj)
    {
        return get_parent_class($obj);
    }


    /**
     * 如果对象属于该类或该类是此对象的父类则返回 TRUE
     *
     * @param mixed $object 类名或者实例对象。
     * @param string $class_name 类名
     * @param bool $allow_string 如果本参数设置为 FALSE，object 就不允许传入字符串类名。这也会在类不存在时，阻止调用自动加载器（autoloader）。
     * @return bool
     */
    public static function isA( $object, string $class_name, bool $allow_string = FALSE ) : bool
    {
        return is_a( $object, $class_name, $allow_string);
    }


    /**
     * 如果此对象是该类的子类，则返回 TRUE
     * 如果对象 object 所属类是类 class_name 的子类，则返回 TRUE，否则返回 FALSE。
     *
     * @param object $object 类名或对象实例
     * @param string $class_name 类名
     * @param bool $allow_string 如果本参数设置为 FALSE，object 就不允许传入字符串类名。这也会在类不存在时，阻止调用自动加载器（autoloader）。
     * @return bool 如果对象属于class_name的子类，则此函数返回TRUE，否则返回FALSE。
     */
    public static function isSubclassOf( object $object, string $class_name, bool $allow_string = FALSE ) : bool
    {
        return is_subclass_of( $object, $class_name,$allow_string);
    }


    /**
     * 返回由类的方法名组成的数组
     *
     * @param mixed $class_name 类名或者对象实例。
     * @return array 返回由 class_name 指定的类中定义的方法名所组成的数组。如果出错，则返回 NULL。
     */
    public static function getClassMethods( $class_name) : array
    {
        return get_class_methods( $class_name);
    }


    /**
     * 返回由类的默认属性组成的数组
     *
     * @param string $class_name
     * @return array 返回从当前作用域可见的已声明属性的关联数组及其默认值。结果数组元素的形式为varname=>value。如果出现错误，则返回FALSE。
     */
    public static function getClassVars( string $class_name) : array
    {
        return get_class_vars( $class_name);
    }







    /**
     * 返回对象的类名
     * 返回对象实例 object 所属类的名字。
     *
     * @param object|null $object 要测试的对象。如果在类里，此参数可以省略。
     * @return string 返回对象实例 object 所属类的名字。如果 object 不是一个对象则返回 FALSE。如果 object 是命名空间中某个类的实例，则会返回带上命名空间的类名。
     * @throws  E_WARNING  如果用其他类型调用 get_class()，而不是一个对象的话，就会产生 E_WARNING 级别的错误。
     */
    public static function getClass(object $object = NULL) : string
    {
        return get_class( $object);
    }

    /**
     * 检查对象或类是否具有该属性
     * 本函数检查给出的 property 是否存在于指定的类中（以及是否能在当前范围内访问）。
     *
     * Note: 与isset（）相反，即使property的值为NULL，property_exists（）也会返回TRUE。
     *
     * @param mixed $class 字符串形式的类名或要检查的类的一个对象
     * @param string $property 属性的名字
     * @return bool 如果该属性存在则返回 TRUE，如果不存在则返回 FALSE，出错返回 NULL。
     */
    public static function propertyExists( $class, string $property) : bool
    {
        return property_exists( $class, $property);
    }

    /**
     * 返回由对象属性组成的关联数组
     * 返回由 obj 指定的对象中定义的属性组成的关联数组。
     *
     * @param object $obj
     * @return array
     */
    public static function getObjectVars( object $obj) : array
    {
        return get_object_vars( $obj);
    }


    /**
     * 检查类的方法是否存在
     * 检查类的方法是否存在于指定的 object中。
     *
     * Note: 如果此类不是已知类，使用此函数会使用任何已注册的 autoloader。
     *
     * @param mixed $object 对象示例或者类名。
     * @param string $method_name 方法名。
     * @return bool 如果 method_name 所指的方法在 object 所指的对象类中已定义，则返回 TRUE，否则返回 FALSE。
     */
    public static function methodExists( $object, string $method_name) : bool
    {
        return method_exists( $object, $method_name);
    }




    /**
     * 后期静态绑定（"Late Static Binding"）类的名称
     * 获取静态方法调用的类名。
     * 返回类的名称，如果不是在类中调用则返回 FALSE。
     *
     * @return string
     */
    public static function getCalledClass() : string
    {
        return get_called_class();
    }



}












