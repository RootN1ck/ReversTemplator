<?php
class ReversTemplator
{
    private $op_token = '\{';
    private $cl_token = '\}';

    public function __construct($op_token=null,$cl_token=null)
    {
        if (isset($op_token) and isset($cl_token) and ($op_token!=$cl_token)) {
            $this->op_token = preg_quote($op_token);
            $this->cl_token = preg_quote($cl_token);
        }
        /*
        $i = func_num_args();
        switch ($i) {
            case 1:
                $this->op_token = preg_quote($op_token);
                $this->cl_token = preg_quote($op_token);
                break;
            case 2:
                $this->op_token = preg_quote($op_token);
                $this->cl_token = preg_quote($cl_token);
            default:
                # code...
                break;
        }
        var_dump($this->op_token,$this->cl_token);
        */
    }

    public function validate(string $var = null):bool
    {
        $pattern = array(
            '/^(',
            $this->op_token,
            '[^',
            $this->op_token,
            $this->cl_token,
            ']+',
            $this->cl_token,
            '([^',
            $this->op_token,
            $this->cl_token,
            ']+|$)|',
            $this->op_token,
            $this->op_token,
            '[^',
            $this->op_token,
            $this->cl_token,
            ']+',
            $this->cl_token,
            $this->cl_token,
            '([^',
            $this->op_token,
            $this->cl_token,
            ']+|$)|[^',
            $this->op_token,
            $this->cl_token,
            ']*)*$/u'
        );
        preg_match_all(implode($pattern),$var,$match);
        if (isset($match[0][0])) {
            if (strlen($match[0][0])==strlen($var)) {
                return true;
            }
        }
        return false;
    }
    public function getParams(string $template, string $out_row){
        // проверяем шаблон
        if (!$this->validate($template)) {
            throw new Exception("Invalid template.");
            
        }
        // парсим шаблон
        $pattern = array(
            '/',
            $this->op_token,
            '([^',
            $this->op_token,
            $this->cl_token,
            ']*)',
            $this->cl_token,
            '|',
            $this->op_token,
            $this->op_token,
            '([^',
            $this->op_token,
            $this->cl_token,
            ']*)',
            $this->cl_token,
            $this->cl_token,
            '|([^',
            $this->op_token,
            $this->cl_token,
            ']*)/u'
        );
        preg_match_all(implode($pattern),$template,$match);
        // парсим выходную строку
        $pattern = null;
        $pattern[] = '/^';
        for ($i=0; $i < count($match[0])-1 ; $i++) {
            if ($match[3][$i]!='') {
                $pattern[]=$match[3][$i];
                continue;
            }
            $pattern[] = '(.*)';
            //$pattern[] = $match[2][$i]!='' ? '(?<'.$match[2][$i].'>.*)' : '(?<'.$match[1][$i].'>.*)';
        }
        $pattern[]='$/u';
        preg_match_all(implode($pattern),$out_row,$out_match);
        if(!isset($out_match[0][0])){
            throw new Exception("Result not matches original template.");
        };
        $params = array();
        for ($i=0,$j=1; $i < count($match[0])-1; $i++) { 
            if ($match[1][$i]!='') {
                $params[$match[1][$i]]=$out_match[$j][0];
                $j++;
            }
            elseif($match[2][$i]!=''){
                $params[$match[2][$i]]=html_entity_decode($out_match[$j][0]);
                $j++;
            }
        }
        return $params;
    }
}
