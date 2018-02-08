<?php

/**
 * Class PhoneNumberAnonymizer
 *
 * Sample usages (parametrized):
 *
 * +48 666 777 888 -> +48 666 777 XXX
 * +246 666 777 888 -> +48 666 7XX XXX
 * +246 666 777 888 -> +48 666 777 88*
 * +246 666 777 888 -> +48 xxx xxx xxx
 */
class PhoneNumberAnonymizer
{
    /**
     * @var string
     */
    private $replacement;

    /**
     * @var int
     */
    private $lastDigits;

    /**
     * PhoneNumberAnonymizer constructor.
     * @param string $replacement
     * @param int $lastDigits
     */
    public function __construct($replacement, $lastDigits = 3)
    {
        $this->replacement = $replacement;
        $this->lastDigits = $lastDigits;
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
        $status = 1;
        $result = [];
        for($i = 0; $i < $len; $i++) {
            if ($status === 1) {
                if (ctype_digit($text[$i])) {
                    $status = 2;
                    $start = $i;
                }
            } else if ($status === 2) {
                if (!ctype_digit($text[$i])) {
                    $status = 1;
                } else {
                    $status =3;
                }

            } else if ($status === 3) {
                if ( !ctype_digit($text[$i])
                    && $text[$i] != ' ' ) {

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

            $len = strlen($temp) - 1;
            $end = 0;
            while ($len > -1 && $end < $this->lastDigits) {
             if (ctype_digit( $temp[$len] ) ) {
                 $temp[$len] = $this->replacement;
                 ++$end;
             }
             --$len;
            }

            return $temp;

        }

        return '';
    }
}