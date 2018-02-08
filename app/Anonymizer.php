<?php

/**
 * Interface Anonymizer
 */
interface Anonymizer
{
    /**
     * @param $text
     * @return string
     */
    public function anonymize($text);
}