<?php

/**
 * Created by PhpStorm.
 * User: Tom  Lloyd
 * Date: 17/12/2018
 * Time: 11:43 PM
 */
class CLI
{
    public $helpText = null;
    public $options = array();
    public $optionsMap = array();
    public $opts = array();
    public $textColour = array(
        'black'         => '0;30',
        'dark_gray'     => '1;30',
        'blue'          => '0;34',
        'light_blue'    => '1;34',
        'green'         => '0;32',
        'light_green'   => '1;32',
        'cyan'          => '0;36',
        'light_cyan'    => '1;36',
        'red'           => '0;31',
        'light_red'     => '1;31',
        'purple'        => '0;35',
        'light_purple'  => '1;35',
        'brown'         => '0;33',
        'yellow'        => '1;33',
        'light_gray'    => '0;37',
        'white'     => '1;37'
    );
    public $backgroundColour = array(
        'black'         => '40',
        'red'           => '41',
        'green'         => '42',
        'yellow'        => '43',
        'blue'          => '44',
        'magenta'       => '45',
        'cyan'          => '46',
        'light_gray'    => '47'
    );



    public function setInfo($content,$textColour=null,$backgroundColour=null)
    {
        $this->helpText = $this->line($content, $textColour, $backgroundColour);
    }

    public function addOptions($longCode,$shortCode,$type=':',$description='')
    {
        $this->options[$longCode] = array(
            "long"=>$longCode,
            "short"=>$shortCode,
            "type"=>$type,
            "description"=>$description
        );
    }
    public function getOption($name)
    {
        if(isset($this->opts[$name])){
            return $this->opts[$name];
        }elseif(isset($this->opts[$this->optionsMap[$name]])) {
            return $this->opts[$this->optionsMap[$name]];
        }
        return null;
    }

    public function addTextColour($colour, $code)
    {
        $this->textColour[$colour] = $code;
    }

    public function addBackgroundColour($colour, $code)
    {
        $this->backgroundColour[$colour] = $code;
    }

    public function getColoredString($string, $textColour = null, $backgroundColour = null)
    {
        $colored_string = "";
        if (isset($this->textColour[$textColour])) {
            $colored_string .= "\033[" . $this->textColour[$textColour] . "m";
        }
        if (isset($this->backgroundColour[$backgroundColour])) {
            $colored_string .= "\033[" . $this->backgroundColour[$backgroundColour] . "m";
        }
        $colored_string .=  $string . "\033[0m";
        return $colored_string;
    }

    public function line($text, $textColour=null,$backgroundColour=null)
    {
        if($textColour === null && $backgroundColour === null){
            return " ".$text."\n";
        }else{
            return " ".$this->getColoredString($text,$textColour,$backgroundColour)."\n";
        }

    }

    public function inline($text, $textColour=null,$backgroundColour=null)
    {
        if($textColour === null && $backgroundColour === null){
            return $text;
        }else{
            return $this->getColoredString($text,$textColour,$backgroundColour);
        }

    }

    public function insertOption($type)
    {
        $options = null;
        switch($type){
            case "short":
                $options = '';
                foreach($this->options as $index=>$opts){
                    $options .= $opts["short"].$opts["type"];
                    if(!empty($opts["short"]) && !empty($opts["long"])) {
                        $this->optionsMap[$opts["short"]] = $opts["long"];
                    }
                }
                return $options;
                break;
            case "long":
                $options = array();
                foreach($this->options as $index=>$opts){
                    $options[] = $opts["long"].$opts["type"];
                    if(!empty($opts["long"]) && !empty($opts["short"])) {
                        $this->optionsMap[$opts["long"]] = $opts["short"];
                    }
                }
                return $options;
                break;
            default:
                return $options;
                break;
        }
    }

    public function hasOptions()
    {
        return (count($this->opts) > 0);
    }

    public function read()
    {
        $this->opts = getopt($this->insertOption("short"), $this->insertOption("long"));
    }

    public function help()
    {
        echo " Information\n";
        echo " ".$this->helpText."\n";
        echo " Usage\n";
        foreach ($this->options as $info){
            echo str_pad(" --".$this->inline($info["long"]),10).str_pad(" -".$this->inline($info["short"]),10).$this->inline($info["description"])."\n";
        }
    }
}