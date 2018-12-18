<?php

include("cli.class.php");

class exampleAPI extends CLI
{
    public function __construct()
    {
        $this->setInfo("This is my TEST CLI file and this is all about it.");
        $this->addOptions("timer", "t", "", "this is a timer");
        $this->addOptions("test1", "a", "", "this is a test param option");
        $this->addOptions("test2", "b", ":", "this is a test param with value requires option");
        $this->addOptions("test3", "c", "::", "this is a test param with value optional option");
    }

    public function Main()
    {
        $this->read();
        if (!$this->hasOptions()) {
            $this->help();
        }

        if ($this->getOption("test1") !== null) {
            echo $this->line("You just ran test 1 param");
        }
        if ($this->getOption("test2") !== null) {
            echo $this->line("You just ran test 2 param with value: ".$this->getOption("test2"));
        }
        if ($this->getOption("test1") !== null) {
            echo $this->line("You just ran test 3 param with optional value: ".$this->getOption("test3"));
        }
        if ($this->getOption("timer") !== null) {
            for ($i=1; $i<=10; $i++) {
                echo $this->line("You just ran timer with {$i}s passed.");
                sleep(1);
            }
        }

    }

}

