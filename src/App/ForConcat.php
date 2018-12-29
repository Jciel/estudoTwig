<?php

namespace App;

use Twig_Extension;
use Twig_SimpleFilter;

class ForConcat extends Twig_Extension
{
    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('forConcat', [$this, 'concatArraysItems']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'forConcat';
    }

    /**
     * @param array $arr
     * @return string
     */
    public function concatArraysItems(array $arr){
        $strFinal = '';
        foreach ($arr as $item) {
            $strFinal .= " $item";
        }
        return trim($strFinal);
    }

    public function __set_state($array)
    {

    }
}
