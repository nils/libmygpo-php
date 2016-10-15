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

class Settings
{
    public $settings;

    public function __construct($reply)
    {
      $this->settings = $reply->body;
    }
    public function __destruct()
    {
    }
    public function settings()
    {
    }

/*signals:
    /**Gets emitted when the data is ready to read
    void finished();
    /**Gets emitted when an parse error ocurred
    void parseError();
    /**Gets emitted when an request error ocurred
    void requestError( QNetworkReply::NetworkError error );*/
}

//typedef QSharedPointer<Settings> SettingsPtr;

}
