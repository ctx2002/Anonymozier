<?php

namespace Base;

/**
 * Class PhoneNumberAnonymizerTest
 * @package Base
 */
class PhoneNumberAnonymizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getData
     * @param string $replacement
     * @param int $lastDigits
     * @param string $text
     * @param string $replaced
     */
    public function testAnonymizeText($replacement, $lastDigits, $text, $replaced)
    {
        $anonymizer = new \PhoneNumberAnonymizer($replacement, $lastDigits);

        $this->assertEquals($replaced, $anonymizer->anonymize($text));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            array(
                'X',
                3,
                'Lorem ipsum',
                'Lorem ipsum',
            ),
            array(
                'X',
                3,
                'Lorem ipsum +48 666 666 666 dolor sit amet',
                'Lorem ipsum +48 666 666 XXX dolor sit amet',
            ),
            array(
                'X',
                0,
                'Lorem ipsum +48 666 666 666 dolor sit amet',
                'Lorem ipsum +48 666 666 666 dolor sit amet',
            ),
            array(
                'X',
                3,
                'Lorem ipsum +48 666 666 666, +48 777 777 777 dolor sit 888 888 888 amet',
                'Lorem ipsum +48 666 666 XXX, +48 777 777 XXX dolor sit 888 888 XXX amet',
            ),
            array(
                'X',
                4,
                'Lorem ipsum +223 666 666 666, +48 777 777 777 dolor sit 888 888 888 amet',
                'Lorem ipsum +223 666 66X XXX, +48 777 77X XXX dolor sit 888 88X XXX amet',
            ),
        );
    }
}