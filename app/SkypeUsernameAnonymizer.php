<?php

/**
 * Class SkypeUsernameAnonymizer
 *
 * Sample usages (parametrized):
 *
 * skype:john.doe -> skype:XXX
 * <a href="skype:john.doe?call">call</a> -> <a href="skype:ZZZ?call">call</a>
 */
class SkypeUsernameAnonymizer implements Anonymizer
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
        $len = strlen($text);
        $start = 0;
        $lastEnd = 0;
        $end = 0;
        $status = 1;
        $result = [];
        for($i = 0; $i < $len; $i++) {
            if ($status === 1) {
                if ($text[$i] == 'S' || $text[$i] == 's') {
                    $status = 2;
                }
            } else if ($status === 2) {
                if ($text[$i] == 'K' || $text[$i] == 'k') {
                    $status = 3;
                } else {
                    $status = 1;
                }

            } else if ($status === 3) {
                if ($text[$i] == 'Y' || $text[$i] == 'y') {
                    $status = 4;
                } else {
                    $status = 1;
                }
            } else if ($status === 4) {
                if ($text[$i] == 'P' || $text[$i] == 'p') {
                    $status = 5;
                } else {
                    $status = 1;
                }
            } else if ($status === 5) {
                if ($text[$i] == 'E' || $text[$i] == 'e') {
                    $status = 6;
                } else {
                    $status = 1;
                }
            } else if ($status === 6) {
                if ($text[$i] == ':') {
                    $start = $i + 1;
                    $status = 7;
                } else {
                    $status = 1;
                }
            } else if ($status === 7) {
                if ($text[$i] == '?' ) {
                    $end = $i;
                    $re = '#';
                    $last = substr($text, $lastEnd, $start-$lastEnd);
                    //var_dump($last,$lastEnd, $start);
                    $result[] = $last;
                    $result[] = $re;
                    $lastEnd = $end;
                    $status = 1;//meet a invalid email char, return to status 1
                }

            } else {
                $status = 1;
            }

        }
        $result[] = substr($text, $end);

        return implode('',$result);
    }
}