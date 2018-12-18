# php-cli-class
A PHP CLI (Command Line Interface) for you to run PHP CLI easily with little fuss over the complexity 

## Adding options
Adding options for use with cli is easy just call
```PHP
$this->addOption("test1","t",":","some description of this param.");
```

| Param | Description  |
|---|---|
| test1   | is the long name of the cli param used  |
| t | is the short name of the cli param used|
| : | denotes value required param types can be; <br>  "" no value needed  <br>  ":" value required <br>  "::" value not required | 
| some...| is the description of the param used |

## Calling Options
calling an option is easy use this function to return the param 
NOTE: default return is null as no value option return false if present so null is used
```php
$this->getOption("test1")
```

## Example Class

```php
<?php //example-cli.php
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
        if ($this->getOption("test3") !== null) {
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
```

## Example Usage
```php
<?php //cli.php
include("example-cli.php");
$cli = new exampleAPI();
$cli->Main();
```

## CLI Usage
```powershell
 C:\User php cli.php -t
 C:\User php cli.php -timer
 C:\User php cli.php -test1="your value"
 C:\User php cli.php -a="your value"
 C:\User php cli.php -a -b=this -c=that
 C:\User php cli.php --test1 --test2=this --test3=that
 C:\User php cli.php -a
```