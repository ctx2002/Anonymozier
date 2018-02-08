<?php

/**
 * Class OfferAnonymizer
 */
class OfferAnonymizer
{
    /**
     * @var array of Anonymizer
     */
    private $anonymizers = array();

    /**
     * @param Anonymizer $anonymizer
     */
    public function addAnonymizer(Anonymizer $anonymizer)
    {
        $this->anonymizers[] = $anonymizer;
    }

    /**
     * @param $text
     * @return $text;
     */
    public function anonymize($text)
    {
        foreach ($this->anonymizers as $anonymizer) {
            $text = $anonymizer->anonymize($text);
        }

        return $text;
    }
}