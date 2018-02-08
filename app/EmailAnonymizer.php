<?php

/**
 * Class EmailAnonymizer
 *
 * Sample usages (parametrized):
 *
 * aaa@aaa.com -> ...@aaa.com
 * aaa@aaa.aaa.com -> ...@aaa.aaa.com
 * a-a@a_a.com -> XXX@a_a.com
 */
class EmailAnonymizer implements Anonymizer
{
    /**
     * @var string
     */
    private $replacement;
    
    /**
     * PhoneNumberAnonymizer constructor.
     * @param string $replacement
     */
    public function __construct($replacement)
    {
        $this->replacement = $replacement;
    }
    
    /**
     * @param string $text
     * @return array of string
     */
    public function anonymize($text)
    {
        // @todo: Implement it
        //a-z, A-Z, 0-9, ., _,
        //$p = '%(.*)([a-z0-9_\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?)(.*)%ism';
        $len = strlen($text);
        $start = 0;
        $lastEnd = 0;
        $end = 0;
        $status = 1;//1 start status
                    //2 email before @ status
                    //3 in @ status
        $result = [];
        for($i = 0; $i < $len; $i++) {
            if ($status === 1) {
                if (ctype_alpha($text[$i])) {
                    $status = 2;
                    $start = $i;
                }
            } else if ($status === 2) {
                if ( !ctype_alpha($text[$i]) && !ctype_digit($text[$i])
                    && $text[$i] != '.' && $text[$i] != '_' && $text[$i] != '@' && $text[$i] != '-') {
                    $status = 1;//meet a invalid email char, return to status 1
                } else {
                    if ($text[$i] === '@') {
                        $status =3;
                    }
                }
            } else if ($status === 3) {
                if ( !ctype_alpha($text[$i]) && !ctype_digit($text[$i])
                    && $text[$i] != '_' && $text[$i] != '-') {

                    if ($text[$i] == '.') {
                        $status = 4;
                    } else {
                        $status = 1;//meet a invalid email char, return to status 1
                    }
                }

            } else if ($status === 4) {
                if ( !ctype_alpha($text[$i]) && !ctype_digit($text[$i])
                    && $text[$i] != '_' && $text[$i] != '-') {
                    $end = $i;

                    $re = $this->replace($text, $start, $end);
                    if ($re !== '') {

                        $last = substr($text, $lastEnd, $start-$lastEnd);
                        $result[] = $last;
                        $result[] = $re;
                    }
                    $lastEnd = $end;
                    $status = 1;//meet a invalid email char, return to status 1
                }

            }

        }
        $result[] = substr($text, $end);

        return implode('',$result);
    }

    private function replace($text, $start, $end)
    {
        if ($end > $start) {
            $temp = '';
            for ($i = $start; $i < $end; $i++) {
                $temp .= $text[$i];
            }

            if (filter_var($temp, FILTER_VALIDATE_EMAIL)) {
                if ($temp[0] !== '_') {
                    $parts = explode("@",$temp);
                    return $this->replacement . "@".$parts[1];
                }
            }
        }

        return '';
    }
}