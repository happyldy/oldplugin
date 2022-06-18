<?php
/**
 * SplObserver 接口与 SplSubject 一起使用以实现观察者设计模式。
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL;


use SplObserver,SplSubject;

class Observer implements SplObserver
{

    public $data = '没有数据';

    /**
     * 当观察者附加到的任何 SplSubject 调用 SplSubject::notify() 时，将调用此方法。
     *
     * @param SplSubject $subject SplSubject 通知观察者更新。
     */
    public function update(SplSubject $subject) : void
    {
        $this->data = $subject->getData();
    }


}

