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
 * Helper class to generate request URL's.
 * Helps to generate URL's for the gpodder requests.
 * This class uses the singleton pattern, to retrieve a
 * reference to the singleton object use the function instance().
 */
function getFormatExtension($f)
{
    $ret;
    switch ($f) {
      case UrlBuilder::JSON:
          $ret = '.json';
          break;
      case UrlBuilder::OPML:
          $ret = '.opml';
          break;
      case UrlBuilder::TEXT:
          $ret = '.txt';
          break;
      case UrlBuilder::XML:
          $ret = '.xml';
          break;
    }

    return $ret;
}

class UrlBuilder
{
    const JSON = 'JSON';
    const OPML = 'OPML';
    const TEXT = 'TEXT';
    const XML = 'XML';

    const s_api2 = '/api/2';
    const s_api1 = '/api/1';

    /**
     * @param i Any value between 1..100. If i <= 0 it will be set to 1
     *
     * @return Request URL to retrieve a list of the top 'i' podcasts
     */
    public static function getToplistUrl($i, $f = self::JSON)
    {
        $numString = strval(($i == 0) ? 1 : $i);

        return Config::instance()->mygpoBaseUrl().
            '/toplist/'.$numString.getFormatExtension($f);
    }

    /**
     * @param i Any value between 1..100. If i <= 0 it will be set to 1
     *
     * @return Rquest URL to retrieve 'i' podcast suggestions
     */
    public static function getSuggestionsUrl($i, $f = self::JSON)
    {
        $numString = strval(($i == 0) ? 1 : $i);

        return Config::instance()->mygpoBaseUrl().
            '/suggestions/'.$numString.getFormatExtension($f);
    }

    /**
     * @param query The query to search in the podcasts name/descrption
     *
     * @return Request URL to retrieve podcasts related to the query
     */
    public static function getPodcastSearchUrl($query, $f = self::JSON)
    {
        return Config::instance()->mygpoBaseUrl().
        '/search'.getFormatExtension($f).'?q='.$query;
    }

    public static function getSubscriptionsUrl($username, $device, $f = self::JSON)
    {
        $deviceString = device ? ('/'.$device) : '';

        return Config::instance()->mygpoBaseUrl().
            '/subscriptions/'.$username.$deviceString.getFormatExtension($f);
    }

    /**
     * @param i Amount of tags. If i == 0 it will be set to 1
     *
     * @return Request URL to retrieve the 'i' most used tags
     */
    public static function getTopTagsUrl($i)
    {
        $numString = strval(($i == 0) ? 1 : $i);

        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/tags/'.$numString.'.json';
    }

    /**
     * @param i Amount of podcasts. If i == 0 it will be set to 1
     *
     * @return Request URL to retrieve the 'i' most-subscribed podcats that are tagged with tag
     */
    public static function getPodcastsOfTagUrl($tag, $i)
    {
        $numString = strval(($i == 0) ? 1 : $i);

        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/tag/'.tag.'/'.$numString.'.json';
    }

    /**
     * @param url The URL of the podcast
     *
     * @return Request URL to retrieve information about the podcast with the given url
     */
    public static function getPodcastDataUrl($url)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/data/podcast'.'.json'.'?url='.$url;
    }

    /**
     * @param podcastUrl URL of the podcast
     * @param episodeUrl URL of the episode that belongs to the podcast-url
     *
     * @return Request URL to retrieve information about the episode with the given episode-url
     */
    public static function getEpisodeDataUrl($podcastUrl, $episodeUrl)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/data/episode'.'.json'.'?podcast='.$podcastUrl.'&url='.$episodeUrl;
    }

    /**
     * @param username User name (gpodder.net). You need to be logged in with username
     *
     * @return Request URL to retrieve a list of all favorite episodes
     */
    public static function getFavEpisodesUrl($username)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/favorites/'.$username.'.json';
    }

    /**
     * @param username User name (gpodder.net). You need to be logged in with username
     * @param deviceId The id of the device
     *
     * @return Request URL to to update the subscription list for a given device
     */
    public static function getAddRemoveSubUrl($username, $deviceId)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/subscriptions/'.$username.'/'.$deviceId.'.json';
    }

    public static function getAccountSettingsUrl($username)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/settings/'.$username.'/account'.'.json';
    }

    public static function getDeviceSettingsUrl($username, $deviceId)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/settings/'.$username.'/device'.'.json'.'?device='.$deviceId;
    }

    public static function getPodcastSettingsUrl($username, $podcastUrl)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/settings/'.$username.'/podcast'.'.json'.'?podcast='.$podcastUrl;
    }

    public static function getEpisodeSettingsUrl($username, $podcastUrl, $episodeUrl)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/settings/'.$username.'/episode'.'.json'.'?podcast='.$podcastUrl.'&episode='.$episodeUrl;
    }

    public static function getDeviceListUrl($username)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/devices/'.$username.'.json';
    }

    public static function getDeviceUpdatesUrl($username, $deviceId, $timestamp)
    {
        $numString = strval($timestamp);

        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/updates/'.$username.'/'.$deviceId.'.json?since='.$numString;
    }

    public static function getRenameDeviceUrl($username, $deviceId)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/devices/'.$username.'/'.$deviceId.'.json';
    }

    public static function getEpisodeActionsUrl($username, $aggregated)
    {
        $agg = '';
        if ($aggregated) {
            $agg = '?aggregated=true';
        } else {
            $agg = '';
        }

        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/episodes/'.$username.'.json'.$agg;
    }

    public static function getEpisodeActionsUrlByPodcast($username, $podcastUrl, $aggregated)
    {
        $agg = '';
        if ($aggregated) {
            $agg = '&aggregated=true';
        } else {
            $agg = '';
        }

        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/episodes/'.$username.'.json?podcast='.$podcastUrl.$agg;
    }

    public static function getEpisodeActionsUrlByDevice($username, $deviceId, $aggregated)
    {
        $agg = '';
        if ($aggregated) {
            $agg = '&aggregated=true';
        } else {
            $agg = '';
        }

        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/episodes/'.$username.'.json?device='.$deviceId.$agg;
    }

    public static function getEpisodeActionsUrlByTimestamp($username, $since)
    {
        $numString = strval(since);

        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/episodes/'.$username.'.json?since='.$numString;
    }

    public static function getEpisodeActionsUrlByPodcastAndTimestamp($username, $podcastUrl, $since)
    {
        $numString = strval(since);

        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/episodes/'.$username.'.json?podcast='.$podcastUrl.'&since='.$numString;
    }

    public static function getEpisodeActionsUrlByDeviceAndTimestamp($username, $deviceId, $since)
    {
        $numString = strval(since);

        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/episodes/'.$username.'.json?device='.$deviceId.'&since='.$numString;
    }

    public static function getUploadEpisodeActionsUrl($username)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/episodes/'.$username.'.json';
    }

    public static function getDeviceSynchronizationStatusUrl($username)
    {
        return Config::instance()->mygpoBaseUrl().
            self::s_api2.'/sync-devices/'.$username.'.json';
    }
}
}
