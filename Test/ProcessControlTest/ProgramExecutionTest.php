<?php



namespace HappyLin\OldPlugin\Test\ProcessControlTest;


use HappyLin\OldPlugin\Test\TraitTest;

class ProgramExecutionTest
{


    use TraitTest;



    public function __construct()
    {

    }


    /**
     * @note 放弃了，在C++中学习
     */
    public function pthreadsTest(){


        //$safe = new \parallel\Runtime();

        $safe = new \Threaded();

        while (count($safe) < 10) {
            $safe[] = count($safe);
        }

        var_dump($safe->chunk(5));
    }


}


