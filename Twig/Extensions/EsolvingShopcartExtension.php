<?php

namespace Esolving\ShopcartBundle\Twig\Extensions;

use Symfony\Component\Translation\Translator;

class EsolvingShopcartExtension extends \Twig_Extension {
    
    private $translator;
    
    public function __construct(Translator $translator) {
        $this->translator = $translator;
    }

    public function getFilters() {
        return array(
            'created_left' => new \Twig_Filter_Method($this, 'createdLeft'),
        );
    }

    public function createdLeft(\DateTime $dateTime) {
        $delta = $dateTime->getTimestamp() - time();
        if ($delta < 0)
            throw new \Exception("createdAgo is unable to handle dates in the past");

        $duration = "";

        if ($delta < 60) {
            // Seconds
            $time = $delta;
            $duration = $time . " second" . (($time === 0 || $time > 1) ? "s" : "");
        } else if ($delta < 3600) {
            // Mins
            $time = floor($delta / 60);
            $duration = $time . " minute" . (($time > 1) ? "s" : "");
        } else if ($delta < 86400) {
            // Hours
//            $time = floor($delta / 3600);
            $timeHour = $delta / 3600;
            $resTimeHour = $delta % 3600;
            
            $timeMinute = $resTimeHour / 60;
            $resTimeMinute = $resTimeHour % 60;
            
//            $timeSecond = $resTimeMinute;
            
            $duration = (integer)$timeHour . " " . (((integer)$timeHour > 1) ? $this->translator->trans('hours',array(),'EsolvingShopcartBundle') : $this->translator->trans('hour',array(),'EsolvingShopcartBundle')) . ' ' . (integer)$timeMinute . " " . (((integer)$timeMinute > 1) ? $this->translator->trans('minutes',array(),'EsolvingShopcartBundle') : $this->translator->trans('minute',array(),'EsolvingShopcartBundle'));
        } else {
            // Days
            $time = floor($delta / 86400);
            $duration = $time . " day" . (($time > 1) ? "s" : "");
        }

        return $duration;
    }

    public function getName() {
        return 'esolving_shopcart_extension';
    }

}