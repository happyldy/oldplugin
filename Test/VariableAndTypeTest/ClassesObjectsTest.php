<?php
/**
 * 这些函数允许你获得类和对象实例的相关信息。你可以获取对象所属的类名，也可以是它的成员属性和方法。通过使用这些函数，你不仅可以找到对象和类的关系，也可以是它们的继承关系（例如，对象类继承自哪个类）。
 */

namespace HappyLin\OldPlugin\Test\VariableAndTypeTest;

use HappyLin\OldPlugin\SingleClass\VariableAndType\ClassesObjects;

use HappyLin\OldPlugin\Test\TraitTest;

use HappyLin\OldPlugin\SingleClass\Date\DateTime;


class ClassesObjectsTest
{

    use TraitTest;

    public $testProperties = 'test';
    private $testPrivateProperties = 'privatetest';

    public function __construct()
    {

    }

    /**
     * @note 类对象和实例相关函数
     */
    public function classesObjectsTest()
    {
        $this->dynamicProperties = 'test';

        var_dump(static::toStr('获取当前脚本中;已定义类的名字组成的数组; get_declared_classes ' )); // , ClassesObjects::getDeclaredClasses()
        var_dump(static::toStr('获取当前脚本中;所有已声明的接口组成的数组; get_declared_interfaces ' )); // , ClassesObjects::getDeclaredInterfaces()
        var_dump(static::toStr('获取当前脚本中;已定义的 traits 的名称组成的数组; get_declared_traits ')); // , ClassesObjects::getDeclaredTraits()

        var_dump(static::toStr('检查类;是否已定义; 类名。名字的匹配是不分区大小写的; class_exists("DateTime", true)', ClassesObjects::classExists('\HappyLin\OldPlugin\SingleClass\Date\DateTime', true) ));
        var_dump(static::toStr('检查interface类;是否已定义; 类名。名字的匹配是不分区大小写的; interface_exists("DateTime", true)', ClassesObjects::interfaceExists('\HappyLin\OldPlugin\SingleClass\Date\DateTime', true) ));
        var_dump(static::toStr('检查trait类;是否已定义; 类名。名字的匹配是不分区大小写的; trait_exists("DateTime", true)', ClassesObjects::traitExists('HappyLin\OldPlugin\Test\traittest', true) ));


        ClassesObjects::classAlias('HappyLin\OldPlugin\SingleClass\Date\DateTime', 'myDate');
        $mydate = new \myDate('20211027T202109');
        $dataTime = new DateTime('20211027T202109');
        var_dump(static::toStr(
            "类别名;为一个类创建别名;  class_alias('DateTime', 'myDate'); \$mydate instanceof DateTime: %s ;\$dataTime instanceof myDate: %s ",
            $mydate instanceof \HappyLin\OldPlugin\SingleClass\Date\DateTime,
            $dataTime instanceof \myDate
        ));

        var_dump(static::toStr('获取类或实例;的父类名。参数类名或者对象实例；get_parent_class ', ClassesObjects::getParentClass($mydate) ));

        var_dump(static::toStr('判断类或实例;属于某类( implements )或某类是此对象的父类( extends )；is_a [ instanceof ]', ClassesObjects::isA($mydate, 'DateTime', false) ));

        var_dump(static::toStr('判断类或实例;某类是此对象的父类( extends )；is_a [ instanceof ]', ClassesObjects::isSubclassOf($mydate, 'DateTime', false) ));

        var_dump(static::toStr('获取类或实例;的方法名组成的数组。参数类名或者对象实例；get_class_methods ', ClassesObjects::getClassMethods($this) ));

        var_dump(static::toStr('获取类;的默认属性组成的数组。get_class_vars ', ClassesObjects::getClassVars('HappyLin\OldPlugin\Test\VariableAndTypeTest\ClassesObjectsTest') ));

        var_dump(static::toStr('获取实例; object 所属类的名字。get_class ', ClassesObjects::getClass($this) ));

        var_dump(static::toStr('判断类或实例;是否具有该属性。property_exists ', ClassesObjects::propertyExists($this, 'testPrivateProperties') ));

        var_dump(static::toStr('获取实例; object 对象中定义的属性组成的关联数组。get_object_vars ', ClassesObjects::getObjectVars($this) ));

        var_dump(static::toStr('获取类或实例;的方法是否存在。method_exists ', ClassesObjects::methodExists($mydate, 'setDate') ));

        var_dump(static::toStr('获取当前调用的静态方法;的类名。get_called_class ', ClassesObjects::getCalledClass() ));

    }


}

