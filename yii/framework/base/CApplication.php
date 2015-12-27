<?php

abstract class CApplication
{
    public function run()
    {
            /*
            if($this->hasEventHandler('onBeginRequest'))
                    $this->onBeginRequest(new CEvent($this));
            register_shutdown_function(array($this,'end'),0,false);
            $this->processRequest();
            if($this->hasEventHandler('onEndRequest'))
                    $this->onEndRequest(new CEvent($this));
             * 
             */
    }
}

