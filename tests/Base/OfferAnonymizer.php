<?php

namespace Base;

/**
 * Class OfferAnonymizerTest
 * @package Base
 */
class OfferAnonymizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getData
     * @param array of Anonymizer $anonymizers
     * @param string $text
     * @param array of string $emails
     */
    public function testAnonymizerEmails($anonymizers, $text, $replaced)
    {
        $offerAnonymizer = new \OfferAnonymizer();

        foreach ($anonymizers as $anonymizer) {
            $offerAnonymizer->addAnonymizer($anonymizer);
        }

        $this->assertEquals($replaced, $offerAnonymizer->anonymize($text));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            array(
                array(),
                'Lorem ipsum a@a.com. <a href="skype:loremipsum?call">call</a> +48 666 777 888',
                'Lorem ipsum a@a.com. <a href="skype:loremipsum?call">call</a> +48 666 777 888',
            ),
            array(
                array(
                    new \EmailAnonymizer('REPLACED'),
                    new \SkypeUsernameAnonymizer('REPLACED'),
                    new \PhoneNumberAnonymizer('XXX', 2),
                ),
                'Lorem ipsum a@a.com. <a href="skype:loremipsum?call">call</a> +48 666 777 888',
                'Lorem ipsum REPLACED@a.com. <a href="skype:REPLACED?call">call</a> +48 666 777 8XX',
            ),
        );
    }
}