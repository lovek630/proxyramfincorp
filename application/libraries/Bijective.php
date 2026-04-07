<?php
class Bijective
{
    public $dictionary = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    public function __construct()
    {
        $this->dictionary = str_split($this->dictionary);
    }

    public function encode($num)
    {
        if ($num == 0)
            return $this->dictionary[0];

        $result = array();
        $base = count($this->dictionary);

        while ($num > 0)
        {
            $result[] = $this->dictionary[($num % $base)];
            $num = floor($num / $base);
        }

        $result = array_reverse($result);

        return join("", $result);
    }

    public function decode($input)
    {
        $i = 0;
        $base = count($this->dictionary);

        $input = str_split($input);

        foreach($input as $char)
        {
            $pos = array_search($char, $this->dictionary);

            $i = $i * $base + $pos;
        }

        return $i;
    }
}
/*@implementation*/
   $bijective = new Bijective();
   //$encode = $bijective->encode(155665767);
   $decode = $bijective->decode('dEt51');
   //echo "EMCODE ::".$encode;
   //echo "\n";
   //echo "DECODE :".$decode;
/*End implementation */
?>
