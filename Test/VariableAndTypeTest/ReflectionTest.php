<?php
/**
 * ReflectionClass  implements Reflector [static export() , __toString()]
 *
 * 除了 Reflection 和 ReflectionType 和 ReflectionGenerator 都继承了 Reflector
 *
 * 错误类  ReflectionException  extends Exception
 *
 * 没写的类：
 *  ReflectionObject 继承了 ReflectionClass； 对比 ReflectionClass 只是初始化限制 对象实例
 *  Reflection 只有 export( Reflector $reflector[, bool $return = false] ) : string 导出一个反射； getModifierNames( int $modifiers) : array 根据标志位域获取修饰符;  两方法;
 *              作用就是获取 将标志位转化为字符串
 *
 */

namespace HappyLin\OldPlugin\Test\VariableAndTypeTest;

use HappyLin\OldPlugin\SingleClass\VariableAndType\Reflection\{ReflectionClass};

use HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple;

use HappyLin\OldPlugin\Test\TraitTest;

use ReflectionClassConstant,ReflectionProperty,ReflectionMethod,ReflectionFunction,ReflectionParameter,ReflectionGenerator,ReflectionZendExtension,ReflectionExtension;
use Symfony\Component\Yaml\Tests\A;
use function HappyLin\OldPlugin\SingleClass\HelpFunction\xrange;


class ReflectionTest
{

    use TraitTest;

    const TEST = 'test';

    public function __construct()
    {

    }


    /**
     * @note 反射 API \ReflectionClass
     * @throws \ReflectionException
     */
    public function reflectionClassTest()
    {
        //$reflectionClassStr = ReflectionClass::export('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple', true);

        //echo (reflectionClassStr);

        //$apple = new Apple();
        //$reflectionClass = new ReflectionClass($apple);

        $reflectionClass = new ReflectionClass('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple');


        var_dump(static::toStr('获取类所定义的文件名。如果这个类是在 PHP 核心或 PHP 扩展中定义的，则返回 FALSE。' . PHP_EOL, $reflectionClass->getFileName("TEST")));
        var_dump(static::toStr('获取类第一行的的行数；', $reflectionClass->getStartLine()));
        var_dump(static::toStr('获取类最后一行的行数；', $reflectionClass->getEndLine()));

        var_dump(static::toStr('获取类名', $reflectionClass->getName()));
        var_dump(static::toStr('获取类的短名，就是不含命名空间（namespace）的那一部分', $reflectionClass->getShortName()));
        var_dump(static::toStr(
            '判断类的类型',
            [
                '类是否是一个抽象类（abstract；isAbstract() :' . var_export($reflectionClass->isAbstract(),true),
                '类是否是一个接口（interface）；isInterface() :' . var_export($reflectionClass->isInterface(),true),
                '类是否为一个 trait；isTrait() :' . var_export($reflectionClass->isTrait(),true),
                '类是否声明为 final；isFinal() :' . var_export($reflectionClass->isFinal(),true),
                '类是否由扩展或核心在内部定义； isInternal():' . var_export($reflectionClass->isInternal(),true),
                '类是否由用户定义，和内置相对；isUserDefined() :' . var_export($reflectionClass->isUserDefined(),true),
                '类是否是一个匿名类；isAnonymous() :'. var_export($reflectionClass->isAnonymous(),true),
            ]
        ));

        var_dump(static::toStr(
            '判断类的实用性',
            [
                '类是否可实例化；isInstantiable():' . var_export($reflectionClass->isInstantiable(),true),
                '类是否可复制； isCloneable():' . var_export($reflectionClass->isCloneable(),true),
                '类是否是指定类的实例；等同于（ instanceof ）； isInstance(object $object) :' . var_export($reflectionClass->isInstance($reflectionClass),true),
                '类是否为指定类的子类；同级别时（ instanceof ）为true; 它为false； isSubclassOf(string $class) :' . var_export($reflectionClass->isSubclassOf($reflectionClass),true),
                '类是否可迭代（即可以在 foreach 中使用）； isIterable() :' . var_export($reflectionClass->isIterable(),true),
                '类是否可迭代（iterateable）； isIterateable() :' . var_export($reflectionClass->isIterateable(),true),
            ]
        ));

        var_dump(static::toStr('获取命名空间；（namespace）的名称', $reflectionClass->getNamespaceName()));
        var_dump(static::toStr('判断命名空间；即类是否定义于该命名空间中', $reflectionClass->inNamespace()));
        var_dump(static::toStr('获取父类', $reflectionClass->getParentClass()));

        var_dump(static::toStr('获取类文档注释；' . PHP_EOL, $reflectionClass->getDocComment()));

        var_dump(static::toStr(
            '获取类访问修饰符的位字段(就abstract 和 final 没用)。ReflectionClass::[IS_IMPLICIT_ABSTRACT# %s (它有抽象abstract方法),IS_EXPLICIT_ABSTRACT# %s (它已明确定义abstract),IS_FINAL# %s ];' . PHP_EOL,
            ReflectionClass::IS_IMPLICIT_ABSTRACT,
            ReflectionClass::IS_EXPLICIT_ABSTRACT,
            ReflectionClass::IS_FINAL,
            $reflectionClass->getModifiers()
        ));

        var_dump(static::toStr('获取类接口；（interface）名称', $reflectionClass->getInterfaceNames()));
        var_dump(static::toStr('判断类接口；是否实现了一个接口（interface）', $reflectionClass->implementsInterface('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\FruitsInterface')));
        var_dump(static::toStr('获取类接口；数组键是接口（interface）的名称，数组的值是 ReflectionClass 对象', $reflectionClass->getInterfaces()));

        var_dump(static::toStr('获取类 traits 数组，traits 的名称的数组', $reflectionClass->getTraitNames()));

        var_dump(static::toStr('获取类 traits 数组, 新的方法名位于键中，原始名称（格式是 "TraitName::original"）位于数组的值中', $reflectionClass->getTraitAliases()));

        var_dump(static::toStr('获取类 traits 数组，键是 trait 的名称，值是 trait 实例的 ReflectionClass', $reflectionClass->getTraits()));

        var_dump(static::toStr('判断类常量；某一常量是否定义hasConstant("TEST")', $reflectionClass->hasConstant("CONSTBASETYPE")));
        var_dump(static::toStr('获取类常量；所有常量; php >= 8.0 默认为所有常量可见性(public private protected)。', $reflectionClass->getConstants()));
        var_dump(static::toStr('获取类常量；某一常量的值', $reflectionClass->getConstant("CONSTBASETYPE")));

        var_dump(static::toStr('获取类常量；反射过的数组(ReflectionClassConstant)。php >= 8.0 默认为所有常量可见性(public private protected)。', $reflectionClass->getReflectionConstants()));

        var_dump(static::toStr('获取类常量；反射过的数组中一个(ReflectionClassConstant)。', $reflectionClass->getReflectionConstant('CONSTBASETYPE')));

        var_dump(static::toStr('获取类属性；默认数组；不区分静态和非静态属性，也不考虑可见性修饰符', $reflectionClass->getDefaultProperties()));

        var_dump(static::toStr('判断类属性；是否已定义；', $reflectionClass->hasProperty('privateStaticVar1')));

        var_dump(static::toStr('获取类属性；设置静态属性的值；\'publicStaticVar1\' => \'newVal\' 私有属性privateStaticVar1改不了', $reflectionClass->setStaticPropertyValue('publicStaticVar1', 'newVal')));

        var_dump(static::toStr('获取类属性；的静态（static）数组；', $reflectionClass->getStaticProperties()));

        var_dump(static::toStr('获取类属性；的静态（static）值；获取不了私有属性的值；', $reflectionClass->getStaticPropertyValue('privateStaticVar1', 'default_value')));

        var_dump(static::toStr(
            '获取类属性；反射过的(ReflectionProperty)；过滤为所需类型的属性ReflectionProperty::[IS_STATIC# %s ,IS_PUBLIC# %s ,IS_PROTECTED# %s ,IS_PRIVATE# %s ]',
            ReflectionProperty::IS_STATIC,
            ReflectionProperty::IS_PUBLIC,
            ReflectionProperty::IS_PROTECTED,
            ReflectionProperty::IS_PRIVATE,
            $reflectionClass->getProperties()
        ));

        var_dump(static::toStr('获取类属性；反射过的的一个(ReflectionProperty)；', $reflectionClass->getProperty('publicVar2')));

        var_dump(static::toStr('判断类方法；是否已定义。', $reflectionClass->hasMethod('type')));

        var_dump(static::toStr(
            '获取类方法；ReflectionMethod 数组。可过滤属性的方法ReflectionMethod::[IS_STATIC# %s ,IS_PUBLIC# %s ,IS_PROTECTED# %s ,IS_PRIVATE# %s ,IS_ABSTRACT# %s ,IS_FINAL# %s ]',
            ReflectionMethod::IS_STATIC,
            ReflectionMethod::IS_PUBLIC,
            ReflectionMethod::IS_PROTECTED,
            ReflectionMethod::IS_PRIVATE,
            ReflectionMethod::IS_ABSTRACT,
            ReflectionMethod::IS_FINAL,
            $methods = $reflectionClass->getMethods()
        ));

        var_dump(static::toStr('获取类方法；ReflectionMethod 数组中一个。', $reflectionClass->getMethod('type')));

        var_dump(static::toStr('创建一个新的类实例；接受可变数目的参数，用于传递到类的构造函数，和 call_user_func() 很相似。 newInstanceArgs([])同理，但它接受数组。', $apple1 = $reflectionClass->newInstance('apple1')));

        var_dump(static::toStr('创建一个新的类实例；但不调用它的构造函数。', $reflectionClass->newInstanceWithoutConstructor()));



        $reflectionClass = new ReflectionClass("ReflectionClass");

        var_dump(static::toStr('获取类扩展；的名称，如果是用户定义的类，则返回 FALSE。 new ReflectionClass("ReflectionClass")=>', $reflectionClass->getExtensionName()));
        var_dump(static::toStr('获取类扩展；的 ReflectionExtension 对象；如果是用户定义的类则返回 NULL。new ReflectionClass("ReflectionClass")=>', $reflectionClass->getExtension()));

    }


    /**
     * @note ReflectionClassConstant 类报告有关类常量的信息。
     */
    public function reflectionClassConstantTest()
    {
        // 两种生成方法
        //$reflectionClass = new ReflectionClass('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple');
        //$reflectionClassConstant = $reflectionClass->getReflectionConstant('CONSTTYPE');

        $reflectionClassConstant = new ReflectionClassConstant('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple', 'CONSTTYPE');

        echo $reflectionClassConstant;

        var_dump($reflectionClassConstant);

        var_dump(static::toStr('获取声明类: ReflectionClass ', $reflectionClassConstant->getDeclaringClass()));

        var_dump(static::toStr('获取常量文档注释；;' . PHP_EOL, $reflectionClassConstant->getDocComment()));
        var_dump(static::toStr(
            '获取类常量的访问修饰符的位域(没用都是0)。ReflectionMethod::[IS_STATIC# %s ,IS_PUBLIC# %s ,IS_PROTECTED# %s ,IS_PRIVATE# %s ,IS_ABSTRACT# %s ,IS_FINAL# %s ] ;' . PHP_EOL,
            ReflectionMethod::IS_STATIC,
            ReflectionMethod::IS_PUBLIC,
            ReflectionMethod::IS_PROTECTED,
            ReflectionMethod::IS_PRIVATE,
            ReflectionMethod::IS_ABSTRACT,
            ReflectionMethod::IS_FINAL,
            $reflectionClassConstant->getModifiers()
        ));


        var_dump(static::toStr('获取常量的名称' , $reflectionClassConstant->getName()));
        var_dump(static::toStr('获取常量的值' , $reflectionClassConstant->getValue()));

        var_dump(static::toStr('获取常量的值' , $reflectionClassConstant->getValue()));

        var_dump(static::toStr(
            '获取常量权限' ,
            [
                '判断类常量是否是公开方法；isPublic() :' . var_export($reflectionClassConstant->isPublic(),true),
                '判断类常量是否是私有方法；isPrivate() :' . var_export($reflectionClassConstant->isPrivate(),true),
                '判断类常量是否是保护方法；(protected)；isProtected() :' . var_export($reflectionClassConstant->isProtected(),true)
            ]

        ));
    }


    /**
     * @note ReflectionProperty 类属性信息
     */
    public function ReflectionPropertyTest()
    {
        $apple = new Apple();

        // 第一种
        //$reflectionClass = new ReflectionClass('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple');
        //$reflectionProperty = $reflectionClass->getProperty('publicVar2');

        // 第二种
        $reflectionProperty = new ReflectionProperty('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple', 'publicVar2');


        var_dump(static::toStr('获取声明类。getDeclaringClass():ReflectionClass|null', $reflectionProperty->getDeclaringClass()));

        var_dump(static::toStr('获取属性名称。getName():string', $reflectionProperty->getName()));

        var_dump(static::toStr(
            '获取属性是否具有与其关联的类型。php >=7.4 hasType():bool',
            version_compare(PHP_VERSION, '7.4', '>=') && $reflectionProperty->hasType()
        ));
        var_dump(static::toStr(
            '获取属性的类型。php >=7.4 getType():ReflectionType|null',
            version_compare(PHP_VERSION, '7.4', '>=') && $reflectionProperty->getType()
        ));
        var_dump(static::toStr(
            '获取属性的值，非静态的，则必须提供一个对象来从中获取该属性，或使用 ReflectionClass::getDefaultProperties()。 getValue([ object $object] ) : mixed',
            $reflectionProperty->getValue($apple)
        ));

        var_dump(static::toStr('设置属性是否可访问,来访问执行私有方法和保护方法。setAccessible( bool $accessible):void', $reflectionProperty->setAccessible(true)));


        var_dump(static::toStr('设置属性值,来访问执行私有方法和保护方法，如果该属性是非静态的，则必须提供一个对象来更改该属性。 如果属性是静态的，则该参数被省略，只需要提供值。setValue( object $object, mixed $value):void', $reflectionProperty->setValue($apple,'publicVar20')));
        //var_dump($apple->publicVar2);

        var_dump(static::toStr(
            '获取属性是否使用默认值声明。php >=8.0  hasDefaultValue():bool',
            version_compare(PHP_VERSION, '8.0', '>=') && $reflectionProperty->hasDefaultValue()
        ));
        var_dump(static::toStr(
            '获取属性的隐式或显式声明的默认值。php >=8.0  getDefaultValue():mixed | null | false',
            version_compare(PHP_VERSION, '8.0', '>=') && $reflectionProperty->getDefaultValue()
        ));

        var_dump(static::toStr('获取属性的文档注释。getDocComment():string' . PHP_EOL, $reflectionProperty->getDocComment()));
        var_dump(static::toStr(
            '获取属性修饰符的数字表示,ReflectionMethod::[IS_STATIC# %s ,IS_PUBLIC# %s ,IS_PROTECTED# %s ,IS_PRIVATE# %s ,IS_ABSTRACT# %s ,IS_FINAL# %s ] 。getModifiers():int',
            ReflectionMethod::IS_STATIC,
            ReflectionMethod::IS_PUBLIC,
            ReflectionMethod::IS_PROTECTED,
            ReflectionMethod::IS_PRIVATE,
            ReflectionMethod::IS_ABSTRACT,
            ReflectionMethod::IS_FINAL,
            $reflectionProperty->getModifiers()
        ));


        var_dump(static::toStr(
            '判断参数限制',
            [
                '判断属性是否在编译时声明，或者属性是否在运行时动态声明; isDefault:' . var_export($reflectionProperty->isDefault(),true),
                '判断属性是否已初始化, 如果该属性是非静态的，则必须提供一个对象来从中获取该属性；php >=7.4  isInitialized([object $object]) :' . var_export(version_compare(PHP_VERSION, '7.4', '>=') && $reflectionProperty->isInitialized($apple),true),
                '判断方法是否是公开方法；isPublic() :' . var_export($reflectionProperty->isPublic(),true),
                '判断方法是否是私有方法；isPrivate() :' . var_export($reflectionProperty->isPrivate(),true),
                '判断方法是否是保护方法；(protected)；isProtected() :' . var_export($reflectionProperty->isProtected(),true),
                '判断方法是否是静态方法；isStatic() :' . var_export($reflectionProperty->isStatic(),true),
            ]

        ));

    }


    /**
     * @param $reflectionFunction
     */
    private function reflectionFunctionAbstract($reflectionFunction)
    {
        echo "<hr>";

        var_dump(static::toStr('获取文件名称。getFileName():string', $reflectionFunction->getFileName()));
        var_dump(static::toStr('判断命名空间是否位于命名空间中。inNamespace():bool', $reflectionFunction->inNamespace()));
        var_dump(static::toStr('获取命名空间。getNamespaceName():string', $reflectionFunction->getNamespaceName()));
        var_dump(static::toStr('获取函数名称。getName():string', $reflectionFunction->getName()));
        var_dump(static::toStr('获取函数短名称。getShortName():string', $reflectionFunction->getShortName()));
        var_dump(static::toStr('判断是否是匿名函数。isClosure():bool', $reflectionFunction->isClosure()));
        var_dump(static::toStr('判断是否是一个生成器函数。isGenerator():bool', $reflectionFunction->isGenerator()));
        var_dump(static::toStr('判断是否是内置函数。isInternal():bool', $reflectionFunction->isInternal()));
        var_dump(static::toStr('判断是否是用户定义。isUserDefined():bool', $reflectionFunction->isUserDefined()));
        var_dump(static::toStr('判断是否为可变参数。isVariadic():bool', $reflectionFunction->isVariadic()));
        var_dump(static::toStr('判断是否返回参考信息。returnsReference():bool', $reflectionFunction->returnsReference()));
        var_dump(static::toStr('判断是否已经弃用。isDeprecated():bool', $reflectionFunction->isDeprecated()));
        var_dump(static::toStr('获取函数的注释文本。getDocComment():string', $reflectionFunction->getDocComment()));
        var_dump(static::toStr('获取开始行号。getStartLine():int', $reflectionFunction->getStartLine()));
        var_dump(static::toStr('获取结束行号。getEndLine():int', $reflectionFunction->getEndLine()));
        var_dump(static::toStr('获取与闭包关联的范围 。getClosureScopeClass():ReflectionClass or null', $reflectionFunction->getClosureScopeClass()));
        var_dump(static::toStr('获取本身的匿名函数 $this 指向。getClosureThis():object or null', $reflectionFunction->getClosureThis()));

        var_dump(static::toStr('获取参数数目，包括可选参数。getNumberOfParameters():int', $reflectionFunction->getNumberOfParameters()));
        var_dump(static::toStr('获取参数必须输入个数。getNumberOfRequiredParameters():int', $reflectionFunction->getNumberOfRequiredParameters()));
        var_dump(static::toStr('获取参数，ReflectionParameter 数组。getParameters():array', $reflectionFunction->getParameters()));

        var_dump(static::toStr('判断函数返回类型是否指定。hasReturnType():bool', $reflectionFunction->hasReturnType()));
        var_dump(static::toStr('获取函数返回类型。getReturnType():ReflectionType【isBuiltin()是否内置类型，allowsNull(),__toString()】',$reflectionType =  $reflectionFunction->getReturnType()));
        echo $reflectionType;

        var_dump(static::toStr('获取静态变量。getStaticVariables():array', $reflectionFunction->getStaticVariables()));

        var_dump(static::toStr('获取扩展信息，如果是用户定义的类则返回 NULL。getExtension():ReflectionExtension or null', $reflectionFunction->getExtension()));
        var_dump(static::toStr('获取扩展；的名称，如果是用户定义的类，则返回 FALSE; getExtensionName():string or false', $reflectionFunction->getExtensionName()));


    }


    /**
     * @note ReflectionFunction 类报告了一个函数的有关信息。
     */
    public function reflectionFunctionTest()
    {
        //$reflectionFunction = new ReflectionFunction('dump');
        $reflectionFunction = new ReflectionFunction('reflectionFunctionTest');

        //echo $reflectionFunction;

        var_dump(static::toStr('为函数返回一个动态创建的闭包Closure,否则 null', $reflectionFunction->getClosure()));

        var_dump(static::toStr('调用函数;传入的参数列表。就像 call_user_func() 一样。invoke(...$args) ', $reflectionFunction->invoke("foobar")));

        var_dump(static::toStr('调用函数并将其参数作为数组传递。invokeArgs(array("foobar")) ', $reflectionFunction->invokeArgs(["foobar"])));

        var_dump(static::toStr('判断函数是否被禁用;通过配置 disable_functions 。isDisabled() ', $reflectionFunction->isDisabled()));


        $this->reflectionFunctionAbstract($reflectionFunction);

    }

    /**
     * @note ReflectionFunction 类报告了一个函数的有关信息。
     */
    public function reflectionMethodTest()
    {
        $apple = new Apple();

        // 第一种种生成方法
        //$reflectionClass = new ReflectionClass('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple');
        //$reflectionMethod = $reflectionClass->getMethod('type');
        // 第二种种生成方法
        //$reflectionMethod = new ReflectionMethod('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple::type');
        // 第三种种生成方法
        $reflectionMethod = new ReflectionMethod('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple', 'type');


        //$reflectionMethod = new ReflectionMethod('ReflectionClass::export');

        //echo $reflectionMethod;

        var_dump(static::toStr('获取被反射的方法所在类的反射实例。getDeclaringClass():ReflectionClass', $reflectionMethod->getDeclaringClass()));
        var_dump(static::toStr(
            '获取方法的修饰符。ReflectionMethod::[IS_STATIC# %s ,IS_PUBLIC# %s ,IS_PROTECTED# %s ,IS_PRIVATE# %s ,IS_ABSTRACT# %s ,IS_FINAL# %s ]; getModifiers():int',
            ReflectionMethod::IS_STATIC,
            ReflectionMethod::IS_PUBLIC,
            ReflectionMethod::IS_PROTECTED,
            ReflectionMethod::IS_PRIVATE,
            ReflectionMethod::IS_ABSTRACT,
            ReflectionMethod::IS_FINAL,
            $reflectionMethod->getModifiers()
        ));

        var_dump(static::toStr('获取方法原型即被重写的父级方法 (如果存在)。getPrototype():ReflectionMethod', $reflectionMethod->getPrototype()));

        var_dump(static::toStr('设置方法是否可访问,来访问执行私有方法和保护方法。setAccessible( bool $accessible):void', $reflectionMethod->setAccessible(true)));

        var_dump(static::toStr('获取函数一个动态创建的闭包Closure（$reflectionMethod 不可以使用静态方法，$object是其子类， 可用Closure::bind()绑定到其他类）。getClosure( object $object):Closure', $reflectionMethod->getClosure($apple)));

        var_dump(static::toStr('调用函数;传入的参数列表。就像 call_user_func() 一样。invoke(object $object[, ...$parameter]):mixed', $reflectionMethod->invoke($apple, null)));

        var_dump(static::toStr('调用函数并将其参数作为数组传递。invokeArgs(object $object, array $args):mixed', $reflectionMethod->invokeArgs($apple, [])));

        var_dump(static::toStr(
            '判断方法的类型',
            [
                '判断方法是否是构造方法；isConstructor() :' . var_export($reflectionMethod->isConstructor(),true),
                '判断方法是否是析构方法；isDestructor() :' . var_export($reflectionMethod->isDestructor(),true),
                '判断方法是否是一个抽象类（abstract）；isAbstract() :' . var_export($reflectionMethod->isAbstract(),true),
                '判断方法是否声明为 final；isFinal() :' . var_export($reflectionMethod->isFinal(),true),
                '判断方法是否是公开方法；isPublic() :' . var_export($reflectionMethod->isPublic(),true),
                '判断方法是否是私有方法；isPrivate() :' . var_export($reflectionMethod->isPrivate(),true),
                '判断方法是否是保护方法；(protected)；isProtected() :' . var_export($reflectionMethod->isProtected(),true),
                '判断方法是否是静态方法；isStatic() :' . var_export($reflectionMethod->isStatic(),true),
            ]
        ));

        $this->reflectionFunctionAbstract($reflectionMethod);

    }


    /**
     * @note ReflectionParameter 取回了函数或方法参数的相关信息。
     * 通过全局方法或类方法获取
     */
    public function reflectionParameterTest()
    {
        // 第一种
        //$reflectionClass = new ReflectionClass('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple');
        //$reflectionMethod = $reflectionClass->getMethod('tasteLike');
        //$reflectionParameters = $reflectionMethod->getParameters();
        //$reflectionParameter = $reflectionParameters[0];


        // 第二种
        $reflectionParameter = new ReflectionParameter(array('HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\Apple', 'tasteLike'), 'taste');

        var_dump(static::toStr('获取声明类。getDeclaringClass():ReflectionClass|null', $reflectionParameter->getDeclaringClass()));
        var_dump(static::toStr('获取声明函数。getDeclaringFunction():ReflectionFunctionAbstract|ReflectionMethod', $reflectionParameter->getDeclaringFunction()));
        var_dump(static::toStr('获取类型提示类，如果参数是某类实例。getClass():ReflectionClass|null', $reflectionParameter->getClass()));
        var_dump(static::toStr('获取参数的名称。getName():string', $reflectionParameter->getName()));
        var_dump(static::toStr('获取参数的位置。getPosition():int', $reflectionParameter->getPosition()));
        var_dump(static::toStr('判断参数是否具有与其关联的类型。hasType():bool', $reflectionParameter->hasType()));
        var_dump(static::toStr('获取参数的关联类型。getType():ReflectionType', $reflectionParameter->getType()));
        var_dump(static::toStr('获取参数的默认值。getDefaultValue():mixed', $reflectionParameter->getDefaultValue()));
        var_dump(static::toStr('获取参数的默认值的常量名称，如果默认值是常量或 null。getDefaultValueConstantName():string|null', $reflectionParameter->getDefaultValueConstantName()));

        var_dump(static::toStr(
            '判断参数限制',
            [
                '判断参数是否允许按值传递；canBePassedByValue() :' . var_export($reflectionParameter->canBePassedByValue(),true),
                '判断参数是否通过引用传入；isPassedByReference() :' . var_export($reflectionParameter->isPassedByReference(),true),
                '判断参数是否被声明为可变参数，就是(...$_)；isVariadic() :' . var_export($reflectionParameter->isVariadic(),true),
                '判断参数是否允许 NULL；allowsNull() :' . var_export($reflectionParameter->allowsNull(),true),
                '判断参数是否需要一个数组；isArray() :' . var_export($reflectionParameter->isArray(),true),
                '判断参数是否必须可调用 ；isCallable() :' . var_export($reflectionParameter->isCallable(),true),
                '判断参数是否可选；isOptional() :' . var_export($reflectionParameter->isOptional(),true),
                '判断参数是否有默认值；isDefaultValueAvailable() :' . var_export($reflectionParameter->isDefaultValueAvailable(),true),
                '判断参数默认值是否为常量；isDefaultValueConstant() :' . var_export($reflectionParameter->isDefaultValueConstant(),true),
            ]
        ));

    }


    /**
     * @note ReflectionGenerator类用于获取生成器的信息。
     */
    public function reflectionGeneratorTest()
    {
        $generator = \xrange(1,6);

        $reflectionGenerator = new ReflectionGenerator($generator);

        var_dump(static::toStr('获取当前正在执行的生成器的完整路径和文件名。getExecutingFile():string' . PHP_EOL, $reflectionGenerator->getExecutingFile()));
        var_dump(static::toStr('获取正在执行的 Generator 对象。getExecutingGenerator():Generator', $reflectionGenerator->getExecutingGenerator()));
        var_dump(static::toStr('获取生成器当前正在执行的行号。getExecutingLine():int', $reflectionGenerator->getExecutingLine()));
        var_dump(static::toStr('获取当前正在执行的生成器的跟踪[DEBUG_BACKTRACE_IGNORE_ARGS 不要在堆栈跟踪中包含函数的参数信息]。getTrace([int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT] ) : array', $reflectionGenerator->getTrace()));
        var_dump(static::toStr('获取生成器有权访问的 $this 值。getThis():object', $reflectionGenerator->getThis()));

        var_dump(static::toStr('获取生成器的函数名称;通过返回从 ReflectionFunctionAbstract 派生的类。getFunction():ReflectionFunctionAbstract',$ReflectionFunctionAbstract =  $reflectionGenerator->getFunction()));

        $this->reflectionFunctionAbstract($ReflectionFunctionAbstract);

    }


//    public function reflectionZendExtensionTest()
//    {
//        $reflectionZendExtension = new ReflectionZendExtension('Counter');
//
//        echo $reflectionZendExtension;
//
//    }


    /**
     * @note ReflectionExtension 报告了一个扩展（extension）的有关信息。
     */
    public function reflectionExtensionTest()
    {

        $reflectionClass = new ReflectionClass('ReflectionExtension');
        $reflectionExtension = $reflectionClass->getExtension();

        $reflectionExtension = new ReflectionExtension('Reflection');

        //echo $reflectionExtension;

        var_dump(static::toStr('获取扩展名称', $reflectionExtension->getName()));
        var_dump(static::toStr('获取扩展的版本号', $reflectionExtension->getVersion()));
        var_dump(static::toStr('判断扩展是否持久化载入；扩展在extension配置中被载入', $reflectionExtension->isPersistent()));
        var_dump(static::toStr('判断扩展是否是临时载入；扩展被dl()载入', $reflectionExtension->isPersistent()));

        var_dump(static::toStr('获取扩展中定义的常量', $reflectionExtension->getConstants()));
        var_dump(static::toStr('获取扩展中依赖，包括必需的、冲突的、可选的', $reflectionExtension->getDependencies()));
        var_dump(static::toStr('获取扩展中定义的函数', $reflectionExtension->getFunctions()));
        var_dump(static::toStr('获取扩展在ini配置文件中的配置', $reflectionExtension->getINIEntries()));


        var_dump(static::toStr('获取扩展信息；输出"phpinfo()"信息中的扩展信息'));

        $reflectionExtension->info();

        var_dump(static::toStr('获取扩展中的类名称列表', $reflectionExtension->getClassNames()));
        var_dump(static::toStr('获取扩展类列表；ReflectionClass 对象', $reflectionExtension->getClasses()));
    }


}



