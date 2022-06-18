<?php
/**
 *
 *
 */
namespace HappyLin\OldPlugin\SingleClass\VariableAndType\Reflection;


use \ReflectionClass as RC,ReflectionProperty, ReflectionMethod, ReflectionClassConstant;


class ReflectionClass extends RC
{

    /**
     * ReflectionClass constructor.
     *
     * @param string | object $objectOrClass  既可以是包含类名的字符串（string）也可以是对象（object）。
     * @throws \ReflectionException 如果要反射的 Class 不存在，抛出异常
     */
    public function __construct($objectOrClass)
    {
        parent::__construct($objectOrClass);
    }


//    /**
//     * 导出一个类
//     * 导出一个反射后的类。
//     *
//     * @param mixed $argument 导出的反射。
//     * @param false $return 设为 TRUE 时返回导出结果，设为 FALSE（默认值）则忽略返回。
//     * @return string|null 如果参数 return 设为 TRUE，导出结果将作为 string 返回，否则返回 NULL。
//     */
//    public static function export($argument, $return = false)
//    {
//        return parent::export($argument, $return);
//    }


    /**
     * 获取类被定义的文件的文件名。
     *
     * @return false|string 返回类所定义的文件名。如果这个类是在 PHP 核心或 PHP 扩展中定义的，则返回 FALSE。
     */
    public function getFileName()
    {
        return parent::getFileName();
    }

    /**
     * 获取起始行号
     *
     * @return int|void 起始的行号，类型是 integer 的。
     */
    public function getStartLine()
    {
        return parent::getStartLine();
    }

    /**
     * 获取最后一行的行数
     * 从用户定义的类获取其最后一行的行数。
     *
     * @return false|int 返回用户定义的类最后一行的行数，如果未知则返回 FALSE。
     */
    public function getEndLine()
    {
        return parent::getEndLine();
    }


    /**
     * 获取类名
     * @return string|void
     */
    public function getName(): string
    {
        return parent::getName();
    }


    /**
     * 检查类是否是抽象类（abstract）
     * @return bool|void
     */
    public function isAnonymous()
    {
        return parent::isAnonymous();
    }


    /**
     * 获取类的短名，就是不含命名空间（namespace）的那一部分
     * @return string
     */
    public function getShortName(): string
    {
        return parent::getShortName();
    }

    /**
     * 获取命名空间（namespace）的名称。
     * @return string|void
     */
    public function getNamespaceName(): string
    {
        return parent::getNamespaceName();
    }


    /**
     * 检查这个类是否定义于一个命名空间中里。
     * @return bool
     */
    public function inNamespace()
    {
        return parent::inNamespace();
    }


    /**
     * 获取父类
     *
     * @return false|RC 一个 ReflectionClass。或 false
     */
    public function getParentClass()
    {
        return parent::getParentClass();
    }


    /**
     * 从一个类中获取文档注释。
     *
     * @return false|string 如果存在则返回文档注释，否则返回 FALSE。
     */
    public function getDocComment()
    {
        return parent::getDocComment();
    }



    /**
     * 获取类的修饰符
     * 返回这个类访问修饰符的位字段。
     *
     * ReflectionClass::IS_IMPLICIT_ABSTRACT
     *      指示了类是一个抽象类（abstract），因为它有抽象（abstract）方法。
     * ReflectionClass::IS_EXPLICIT_ABSTRACT
     *      指示了类是一个抽象类（abstract），因为它已明确定义。
     * ReflectionClass::IS_FINAL
     *      指示这是一个 final 类。
     *
     *
     * @return int|void 返回 修饰符常量 的位掩码。
     */
    public function getModifiers()
    {
        return parent::getModifiers();
    }


    /**
     * 获取接口（interface）名称。
     * @return string[] 一个数值数组，接口（interface）的名称是数组的值。
     */
    public function getInterfaceNames(): array
    {
        return parent::getInterfaceNames();
    }

    /**
     * 检查它是否实现了一个接口（interface）。
     * @param string $interface 接口（interface）的名称。
     * @return bool
     */
    public function implementsInterface($interface): bool
    {
        return parent::implementsInterface($interface);
    }


    /**
     * 获取接口
     * @return RC[]|void 接口的关联数组，数组键是接口（interface）的名称，数组的值是 ReflectionClass 对象。
     */
    public function getInterfaces(): array
    {
        return parent::getInterfaces();
    }




    /**
     * @return string[] | null   返回这个类所使用 traits 的名称的数组;出现错误的情况下返回 NULL。
     */
    public function getTraitNames()
    {
        return parent::getTraitNames();
    }

    /**
     * 返回 trait 别名的一个数组;
     *
     * @return string[] | null 返回了一个数组，新的方法名位于键中，原始名称（格式是 "TraitName::original"）位于数组的值中。出现一个错误的情况下返回 NULL。
     */
    public function getTraitAliases()
    {
        return parent::getTraitAliases();
    }


    /**
     * @return RC[] | null 返回了一个数组，键是 trait 的名称，值是 trait 实例的 ReflectionClass。出现错误的情况下返回 NULL。
     */
    public function getTraits()
    {
        return parent::getTraits();
    }




    /**
     * 检查常量是否已经定义
     *
     * @param string $name 要被检查的常量名称。
     * @return bool 如果已定义返回 TRUE，否则返回 FALSE。
     */
    public function hasConstant($name): bool
    {
        return parent::hasConstant($name);
    }


    /**
     * 获取一组常量
     * ReflectionClassConstant::IS_PUBLIC | ReflectionClassConstant::IS_PROTECTED | ReflectionClassConstant::IS_PRIVATE
     *
     * @param int|string $filter 可选过滤器，用于过滤所需的恒定可见性。 它使用 ReflectionClassConstant 常量进行配置，并且默认为所有常量可见性。 php >= 8.0
     * @return array|void 常量的数组，常量名是数组的键，常量的值是数组的值。
     */
    public function getConstants($filter = null): array
    {
        return parent::getConstants(...func_get_args());
    }

    /**
     * 获取定义过的一个常量
     *
     * @param string $name 常量的名称
     * @return false|mixed|void 常量的值。
     */
    public function getConstant($name)
    {
        return parent::getConstant($name);
    }


    /**
     * 检索反射常数。
     *
     * $filter = ReflectionClassConstant::IS_PUBLIC | ReflectionClassConstant::IS_PROTECTED | ReflectionClassConstant::IS_PRIVATE
     *
     * @param int|string $filter
     * @return ReflectionClassConstant[]|void
     */
    public function getReflectionConstants($filter = null)
    {
        return parent::getReflectionConstants(...func_get_args());
    }

    /**
     * 获取类常量的 ReflectionClassConstant
     *
     * @param string $name
     * @return ReflectionClassConstant|void
     */
    public function getReflectionConstant($name)
    {
        return parent::getReflectionConstant($name);
    }




    /**
     * 获取默认属性
     * 获取类的默认属性（包括了继承的属性）。
     *
     * Note: 此方法仅适用于在内部类上使用时的静态属性。在用户定义的类上使用此方法时，无法跟踪静态类属性的默认值。
     *
     * @return mixed[]|void 默认属性的数组，其键是属性的名称，其值是属性的默认值或者在属性没有默认值时是 NULL。这个函数不区分静态和非静态属性，也不考虑可见性修饰符。
     */
    public function getDefaultProperties(): array
    {
        return parent::getDefaultProperties();
    }


    /**
     *  检查属性是否已定义
     * @param string $name 待检查的属性的名称。
     * @return bool
     */
    public function hasProperty($name): bool
    {
        return parent::hasProperty($name);
    }

    /**
     * 设置静态属性的值
     *
     * @param string $name 属性的名称
     * @param mixed $value 属性的值。
     */
    public function setStaticPropertyValue($name, $value)
    {
        parent::setStaticPropertyValue($name, $value);
    }

    /**
     * 获取静态（static）属性
     *
     * @return mixed[]|void 静态（static）的属性，类型是 array。
     */
    public function getStaticProperties(): array
    {
        return parent::getStaticProperties();
    }

    /**
     * 获取这个类里静态（static）属性的值。
     *
     * @param string $name 静态属性的名称，来返回它的值。
     * @param null $default 假如类没有定义 name 的 static 属性，将返回一个默认值。如果属性不存在，并且省略了此参数，将会抛出 ReflectionException 。
     * @return mixed|void
     */
    public function getStaticPropertyValue($name, $default = null)
    {
        return parent::getStaticPropertyValue(...func_get_args());
    }


    /**
     * 获取反射过的属性。
     *
     * $filter
     *  ReflectionProperty::IS_STATIC
     *      指示了 static 的属性。
     *  ReflectionProperty::IS_PUBLIC
     *      指示了 public 的属性。
     *  ReflectionProperty::IS_PROTECTED
     *      指示了 protected 的属性。
     *  ReflectionProperty::IS_PRIVATE
     *      指示了 private 的属性。
     *
     *
     * @param null $filter 可选的过滤器，过滤为所需类型的属性。它使用 ReflectionProperty 常量 来配置，默认获取所有类型的属性。
     * @return \ReflectionProperty[]|void
     */
    public function getProperties($filter = null)
    {
        return parent::getProperties(...func_get_args());
    }



    /**
     * 获取类的一个属性的 ReflectionProperty
     *
     * @param string $name 属性名。
     * @return \ReflectionProperty|void 一个 ReflectionProperty。
     * @throws \ReflectionException If no property exists by that name.
     */
    public function getProperty($name): ReflectionProperty
    {
        return parent::getProperty($name);
    }



    /**
     * 获取类的方法的一个数组。
     *
     * filter
     *  过滤结果为仅包含某些属性的方法。默认不过滤。的按位或（OR），就会返回任意满足条件的属性。
     *      ReflectionMethod::IS_STATIC、
     *      ReflectionMethod::IS_PUBLIC、
     *      ReflectionMethod::IS_PROTECTED、
     *      ReflectionMethod::IS_PRIVATE、
     *      ReflectionMethod::IS_ABSTRACT、
     *      ReflectionMethod::IS_FINAL
     *  Note: 请注意：其他位操作，例如 ~ 无法按预期运行。这个例子也就是说，无法获取所有的非静态方法。
     *
     * @param null $filter 过滤结果为仅包含某些属性的方法。默认不过滤。
     * @return \ReflectionMethod[]|void 包含每个方法 ReflectionMethod 对象的数组。
     */
    public function getMethods($filter = null): array
    {
        return parent::getMethods(...func_get_args());
    }



    /**
     * 检查一个类中指定的方法是否已定义。 
     *
     * @param string $name 要检查的方法的名称。
     * @return bool 如果有这个方法返回 TRUE，否则返回 FALSE。
     */
    public function hasMethod($name): bool
    {
        return parent::hasMethod($name);
    }


    /**
     * 获取一个类方法的 ReflectionMethod。
     *
     * @param string $name 要反射的方法名称。
     * @return \ReflectionMethod 一个 ReflectionMethod。
     * @throws \ReflectionException 如果方法不存在则会抛出 ReflectionException 异常。
     */
    public function getMethod($name): ReflectionMethod
    {
        return parent::getMethod($name);
    }


    /**
     * 创建一个新的类实例而不调用它的构造函数
     * @return object|void
     * @throws \ReflectionException
     */
    public function newInstanceWithoutConstructor()
    {
        return parent::newInstanceWithoutConstructor();
    }


    /**
     * 获取已定义类的扩展的 ReflectionExtension 对象。
     * @return \ReflectionExtension|void 类所处的扩展的 ReflectionExtension 对象的表示，如果是用户定义的类则返回 NULL。
     */
    public function getExtension()
    {
        return parent::getExtension();
    }


    /**
     *  获取定义的类所在的扩展的名称
     *
     * @return false|string 获取定义的类所在的扩展的名称，如果是用户定义的类，则返回 FALSE。
     */
    public function getExtensionName()
    {
        return parent::getExtensionName();
    }

}


