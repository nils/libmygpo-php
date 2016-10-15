<?php
/*
libmygpo-php - PHP Client Library for gpodder.net
Copyright (C) 2016 Nils Schnabel <libmygpo-php@to.nilsschnabel.de>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

namespace mygpo
{

//TODO: More config entries (mygpo-feedservice baseurl), let class inherit from QObject, set everything as a Property
class Config
{
    public static function instance()
    {
        if (!self::$s_instance) {
            self::$s_instance = new self();
        }

        return self::$s_instance;
    }

    public function majorVersion()
    {
        return self::MYGPO_QT_VERSION_MAJOR;
    }
    public function minorVersion()
    {
        return self::MYGPO_QT_VERSION_MINOR;
    }
    public function patchVersion()
    {
        return self::MYGPO_QT_VERSION_PATCH;
    }

    public function version()
    {
        return $this->majorVersion().'.'.$this->minorVersion().'.'.$this->patchVersion();
    }

    public function mygpoBaseUrl()
    {
        return $this->m_mygpoBaseUrl;
    }
    public function setMygpoBaseUrl($mygpoBaseUrl)
    {
        $this->m_mygpoBaseUrl = $mygpoBaseUrl;
    }

    public function userAgent()
    {
        $userAgent = '';
        if ($this->m_userAgentPrefix) {
            $userAgent = $this->m_userAgentPrefix.' ';
        }
        $userAgent = $userAgent.'libmygpo-php '.$this->version();

        return $userAgent;
    }

    public function userAgentPrefix()
    {
        return $this->m_userAgentPrefix;
    }

    public function setUserAgentPrefix($prefix)
    {
        $this->m_userAgentPrefix = $prefix;
    }

    private function __construct()
    {
    }
    private static $s_instance;

    private $m_mygpoBaseUrl = 'https://gpodder.net';
    private $m_userAgentPrefix = '';

    const MYGPO_QT_VERSION_MAJOR = 0;
    const MYGPO_QT_VERSION_MINOR = 0;
    const MYGPO_QT_VERSION_PATCH = 1;
}

}
