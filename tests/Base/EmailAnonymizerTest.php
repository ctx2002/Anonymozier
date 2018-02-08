<?php

namespace Base;

/**
 * Class EmailAnonymizerTest
 * @package Base
 */
class EmailAnonymizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    protected function setup()
    {
        $this->anonymizer = new \EmailAnonymizer('...');
    }

    /**
     * @dataProvider getData
     * @param string $text
     * @param string $replaced
     */
    public function testAnonymizeText($text, $replaced)
    {
        $this->assertEquals($replaced, $this->anonymizer->anonymize($text));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            array(
                'Lorem ipsum',
                'Lorem ipsum',
            ),
            array(
                'Lorem ipsum a@a.com dolor sit amet',
                'Lorem ipsum ...@a.com dolor sit amet',
            ),
            array(
                'Lorem ipsum --@--.--',
                'Lorem ipsum --@--.--',
            ),
            array(
                'Lorem ipsum ...@a.com, bb12@bb12.com dolor sit abc-abc@abc.edu.co.uk amet',
                'Lorem ipsum ...@a.com, ...@bb12.com dolor sit ...@abc.edu.co.uk amet',
            ),
            array(
                'Lorem ipsum a@a.com. bb12@bb12.com dolor sit ABC-ABC@abc.edu.co.uk amet',
                'Lorem ipsum ...@a.com. ...@bb12.com dolor sit ...@abc.edu.co.uk amet',
            ),
        );
    }
}