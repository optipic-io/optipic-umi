<?php

/** Класс обработчиков событий */
class OptipicHandlers
{

    /** @var optipic $module */
    public $module;

    public function onSystemBufferSend(iUmiEventPoint $eventPoint){

        if ($eventPoint->getMode() != "before") {
            return;
        }

        $buffer = &$eventPoint->getRef('buffer');
        $buffer = $this->module->changeContent($buffer);

    }

}