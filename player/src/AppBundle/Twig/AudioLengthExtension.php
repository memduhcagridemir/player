<?php

namespace AppBundle\Twig;

use Twig_Extension;

class AudioLengthExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('sectotime', array($this, 'secondsToTime')),
        );
    }

    public function secondsToTime($seconds)
    {
        return gmdate("i:s", (int) $seconds);;
    }
}