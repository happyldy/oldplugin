<?php
/**
 * SplObserver 接口与 SplSubject 一起使用以实现观察者设计模式。
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL;


use SplSubject, SplObserver, SplObjectStorage;

class Subject implements SplSubject
{

    private $data = '没有数据';

    protected $observers = null;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }


    /**
     * 更新数据并通知所有观察者
     * @param $data
     */
    public function updateData($data)
    {
        $this->data = $data;
        $this->notify();
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * 附加一个 SplObserver，以便它可以收到更新通知。
     *
     * @param SplObserver $observer 要附加的 SplObserver。
     */
    public function attach(SplObserver $observer) : void
    {
        $this->observers->attach($observer);
    }

    /**
     * 将观察者与主题分离，不再通知它更新。
     * @param SplObserver $observer 要分离的 SplObserver
     */
    public function detach(SplObserver $observer) : void
    {
        $this->observers->detach($observer);
    }


    /**
     * 通知观察者
     */
    public function notify() : void
    {
        foreach ($this->observers as $observer){
            $observer->update($this);
        }
    }



}

