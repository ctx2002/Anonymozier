<?php

namespace Base;

/**
 * Class SkypeUsernameanonymizeorTest
 * @package Base
 */
class SkypeUsernameanonymizeorTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    protected function setup()
    {
        $this->anonymizer = new \SkypeUsernameAnonymizer('#');
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
                'Lorem ipsum <a href="skype:loremipsum?call">call</a> dolor sit amet',
                'Lorem ipsum <a href="skype:#?call">call</a> dolor sit amet',
            ),
            array(
                'Lorem ipsum  <a href="skype:loremipsum?call">call</a>, dolor sit <a href="skype:IPSUMLOREM?chat">chat</a> amet',
                'Lorem ipsum  <a href="skype:#?call">call</a>, dolor sit <a href="skype:#?chat">chat</a> amet',
            ),
        );
    }
}