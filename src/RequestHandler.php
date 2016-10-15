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

/**
 * Class for sending HTTP requests and handle the servers response.
 */
class RequestHandler
{
    /**
     * @param username The username that should be used for authentication if required
     * @param password The password that should be used for authentication if required
     */
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function __destruct()
    {
    }

    /**
     * Sends a GET request with the given url and receives the servers response.
     *
     * @param response The servers response will be written into this QByteArray
     * @param url The request url (without http://) as QString
     *
     * @return 0 if the request was successful, corresponding ErrorCode if unsuccessful
     */
    public function getRequest($url)
    {
        $res = \Requests::get($url, $this->addUserAgent(), $this->addDefaultOptions());
        $res->throw_for_status(true);

        return $res;
    }

    /**
     * Sends a GET request with the given url, adds auth Data to the URL and receives the servers response.
     *
     * @param response The servers response will be written into this QByteArray
     * @param url The request url (without http://) as QString
     *
     * @return 0 if the request was successful, corresponding ErrorCode if unsuccessful
     */
    public function getAuthGetRequest($url)
    {
        //var_dump(array("method" => "GET", "url" => $url, "headers" => $this->addUserAgent(), "options" => $this->addDefaultOptions($this->addAuthData())));
        $res = \Requests::get($url, $this->addUserAgent(), $this->addDefaultOptions($this->addAuthData()));

        $res->throw_for_status(true);

        return $res;
    }

    /**
     * Sends a POST request with the given url and data, adds auth Data and receives the servers response.
     *
     * @param data The data to send to the url
     * @param url The request url (without http://) as QString
     *
     * @return 0 if the request was successful, corresponding ErrorCode if unsuccessful
     */
    public function getPostRequest($data, $url)
    {
        $res = \Requests::post($url, $this->addUserAgent(), $data, $this->addDefaultOptions($this->addAuthData()));
        //var_dump(array("method" => "POST", "url" => $url, "data" => $data, "headers" => $this->addUserAgent(), "options" => $this->addDefaultOptions($this->addAuthData())));
        $res->throw_for_status(true);

        return $res;
    }

    private $username;
    private $password;

    private function addAuthData($options = null)
    {
        if (!$options) {
            $options = array();
        }
        $options['auth'] = new \Requests_Auth_Basic(array($this->username, $this->password));

        return $options;
    }
    private function addUserAgent($headers = null)
    {
        if (!$headers) {
            $headers = array();
        }
        $headers['User-Agent'] = Config::instance()->userAgent();

        return $headers;
    }
    private function addDefaultOptions($options)
    {
        if (!$options) {
            $options = array();
        }
        $options['follow_redirects'] = true;
        $options['timeout'] = 30;

        return $options;
    }
}

}
