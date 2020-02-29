<?php

namespace models\interfaces;

interface Visitors
{
    public function getSiteName();
    public function setSiteName($name);
    public function getUserIp();
    public function setUserIp($ip);
    public function getUrl();
    public function setUrl($url);
    public function setSiteViewDates($start, $end);
    public function getViews($byUserIp = false, $byUrl = false);
    public function getViewsCount($byUserIp = false, $byUrl = false);
    public function addViewer();

}