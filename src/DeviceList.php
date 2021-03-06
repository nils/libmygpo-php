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

class DeviceList
{
    protected $devices = array();
    public function __construct($reply)
    {
      $this->parseData($reply->body);
    }
    public function devices()
    {
      return $devices;
    }
    protected function parseData($data) {
      $parsed = json_decode($data);

      foreach ($parsed as $deviceData) {
        
        $this->devices[] = new Device($deviceData);
      }
    }
}

}
