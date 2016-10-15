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
class ApiRequest
{
    public function __construct($username, $password)
    {
        $this->requestHandler = new RequestHandler($username, $password);
    }

    //SIMPLE API

    /**
     * Returns the OPML Result for the Simple API Call "Downloading Podcast Toplists".
     *
     * @param count The number of Podcasts that should be returned - will be set to to 100 if > 100 or < 1
     *
     * @return A Pointer to a QNetworkReply which receives network signals and will contain the data
     */
    public function toplistOpml($count)
    {
        $requestUrl = UrlBuilder::getToplistUrl($count, UrlBuilder::OPML);

        return $this->requestHandler->getRequest($requestUrl);
    }

    /**
     * Returns the OPML Result for the Simple API Call "Searching for Podcasts".
     *
     * @param query The String you want to search for
     *
     * @return A Pointer to a QNetworkReply which receives network signals and will contain the data
     */
    public function searchOpml($query)
    {
        $requestUrl = UrlBuilder::getToplistUrl($count, UrlBuilder::OPML);

        return $this->requestHandler->getRequest($requestUrl);
    }

    /**
     * Returns the OPML Result for the Simple API Call "Downloading podcast suggestions"
     * Requires Authentication.
     *
     * @param count The maximum number of Podcasts that should be returned - will be set to to 100 if > 100 or < 1
     *
     * @return A Pointer to a QNetworkReply which receives network signals and will contain the data
     */
    public function suggestionsOpml($count)
    {
        $requestUrl = UrlBuilder::getSuggestionsUrl($count, UrlBuilder::OPML);

        return $this->requestHandler->getAuthGetRequest($requestUrl);
    }

    public function downloadSubscriptionsOpml($username, $device = '')
    {
        $requestUrl = UrlBuilder::getSubscriptionsUrl($username, $device, UrlBuilder::OPML);

        return $this->requestHandler->getAuthGetRequest($requestUrl);
    }

    /**
     * Returns the TXT Result for the Simple API Call "Downloading Podcast Toplists".
     *
     * @param count The number of Podcasts that should be returned - will be set to to 100 if > 100 or < 1
     *
     * @return A Pointer to a QNetworkReply which receives network signals and will contain the data
     */
    public function toplistTxt($count)
    {
        $requestUrl = UrlBuilder::getToplistUrl($count, UrlBuilder::TEXT);

        return $this->requestHandler->getRequest($requestUrl);
    }

    /**
     * Returns the TXT Result for the Simple API Call "Searching for Podcasts".
     *
     * @param query The String you want to search for
     *
     * @return A Pointer to a QNetworkReply which receives network signals and will contain the data
     */
    public function searchTxt($query)
    {
        $requestUrl = UrlBuilder::getPodcastSearchUrl(query, UrlBuilder::TEXT);

        return $this->requestHandler->getRequest($requestUrl);
    }

    /**
     * Returns the TXT Result for the Simple API Call "Downloading podcast suggestions"
     * Requires Authentication.
     *
     * @param count The maximum number of Podcasts that should be returned - will be set to to 100 if > 100 or < 1
     *
     * @return A Pointer to a QNetworkReply which receives network signals and will contain the data
     */
    public function suggestionsTxt($count)
    {
        $requestUrl = UrlBuilder::getSuggestionsUrl($count, UrlBuilder::TEXT);

        return $this->requestHandler->getAuthGetRequest($requestUrl);
    }

    public function downloadSubscriptionsTxt($username, $device = '')
    {
        $requestUrl = UrlBuilder::getSubscriptionsUrl($username, $device, UrlBuilder::TEXT);

        return $this->requestHandler->getAuthGetRequest($requestUrl);
    }

    /**
     * Returns the TXT Result for the Simple API Call "Downloading Podcast Toplists".
     *
     * @param count The number of Podcasts that should be returned - will be set to to 100 if > 100 or < 1
     *
     * @return A Pointer to a QNetworkReply which receives network signals and will contain the data
     */
    public function toplistXml($count)
    {
        $requestUrl = UrlBuilder::getToplistUrl($count, UrlBuilder::XML);

        return $this->requestHandler->getRequest($requestUrl);
    }

    /**
     * Returns the XML Result for the Simple API Call "Searching for Podcasts".
     *
     * @param query The String you want to search for
     *
     * @return A Pointer to a QNetworkReply which receives network signals and will contain the data
     */
    public function searchXml($query)
    {
        $requestUrl = UrlBuilder::getPodcastSearchUrl(query, UrlBuilder::XML);

        return $this->requestHandler->getRequest($requestUrl);
    }

    /**
     * Returns the Result for the Simple API Call "Downloading Podcast Toplists".
     *
     * @param count The number of Podcasts that should be returned - will be set to to 100 if > 100 or < 1
     *
     * @return List of Podcast Objects containing the Data from gPodder
     */
    public function toplist($count)
    {
        $requestUrl = UrlBuilder::getToplistUrl(count);
        $reply = $this->requestHandler->getRequest($requestUrl);

        return new PodcastList($reply);
    }

    /**
     * Returns the Result for the Simple API Call "Searching for Podcasts".
     *
     * @param query The String you want to search for
     *
     * @return List of Podcast Objects containing the Data from gPodder
     */
    public function search($query)
    {
        $requestUrl = UrlBuilder::getPodcastSearchUrl(query);
        $reply = $this->requestHandler->getRequest($requestUrl);

        return new PodcastList($reply);
    }

    /**
     * Returns the Result for the Simple API Call "Downloading podcast suggestions"
     * Requires Authentication.
     *
     * @param count The maximum number of Podcasts that should be returned - will be set to to 100 if > 100 or < 1
     *
     * @return List of Podcast Objects containing the Data from gPodder
     */
    public function suggestions($count)
    {
        $requestUrl = UrlBuilder::getSuggestionsUrl(count);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new PodcastList($reply);
    }

    public function downloadSubscriptionsJson($username, $device = '')
    {
        $requestUrl = UrlBuilder::getSubscriptionsUrl($username, $device);

        return json_decode($this->requestHandler->getAuthGetRequest($requestUrl)->body);
    }

    //ADVANCED API

    /**
     * Returns the Result for the Advanced API Call "Retrieving Podcasts of a Tag".
     *
     * @param query The number of Podcasts that should be returned - will be set to to 100 if > 100 or < 1
     * @param tag The Tag for which Podcasts should be retrieved
     *
     * @return List of Podcast Objects containing the Data from gPodder
     */
    public function podcastsOfTag($count, $tag)
    {
        $requestUrl = UrlBuilder::getPodcastsOfTagUrl(tag, count);
        $reply = $this->requestHandler->getRequest($requestUrl);

        return new PodcastList($reply);
    }

    /**
     * Returns the Result for the Advanced API Call "Retrieving Podcast Data".
     *
     * @param podcasturl Url of the Podcast for which Data should be retrieved
     *
     * @return Podcast Object containing the Data from gPodder
     */
    public function podcastData($podcasturl)
    {
        $requestUrl = UrlBuilder::getPodcastDataUrl(podcasturl.toString());
        $reply = $this->requestHandler->getRequest($requestUrl);

        return new Podcast($reply);
    }

    /**
     * Returns the Result for the Advanced API Call "Retrieving Episode Data".
     *
     * @param podcasturl Url of the Podcast that contains the Episode
     * @param episodeurl Url of the Episode Data for which Data should be retrieved
     *
     * @return Episode Object containing the Data from gPodder
     */
    public function episodeData($podcasturl, $episodeurl)
    {
        $requestUrl = UrlBuilder::getEpisodeDataUrl(podcasturl.toString(), episodeurl.toString());
        $reply = $this->requestHandler->getRequest($requestUrl);

        return new Episode($reply);
    }

    /**
     * Returns the Result for the Advanced API Call "Listing Favorite Episodes".
     *
     * @param username The User whose Favorite Episodes should be retrieved
     *
     * @return List of Episode Objects containing the Data from gPodder
     */
    public function favoriteEpisodes($username)
    {
        $requestUrl = UrlBuilder::getFavEpisodesUrl(username);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new EpisodeList($reply);
    }

    /**
     * Returns the Result for the Advanced API Call "Retrieving Top Tags".
     *
     * @param count The number of Tags that should be returned - will be set to to 100 if > 100 or < 1
     *
     * @return List of Tag Objects containing the Data from gPodder
     */
    public function topTags($count)
    {
        $requestUrl = UrlBuilder::getTopTagsUrl(count);
        $reply = $this->requestHandler->getRequest($requestUrl);

        return new TagList($reply);
    }

    /**
     * Uploads Data & returns the Result for the Advanced API Call "Add/remove subscriptions"
     * Requires Authentication.
     *
     * @param username User for which this API Call should be executed
     * @param $device gPodder $device for which this API Call should be executed
     * @param add URLs of Podcasts that should be added to the Subscriptions of the User
     * @param remove URLs of Podcasts that should be removed from the Subscriptions of the User
     */
    public function addRemoveSubscriptions($username, $device, $add, $remove)
    {
        $requestUrl = UrlBuilder::getAddRemoveSubUrl($username, $device);
        $data = JsonCreator::addRemoveSubsToJSON($add, $remove);
        $reply = $this->requestHandler->getPostRequest($data, $requestUrl);
        return json_decode($reply->body);
    }

    /**
     * Retrieve settings which are attached to an account.
     *
     * @param username Username of the targeted account
     *
     * @return Received settings as key-value-pairs
     */
    public function accountSettings($username)
    {
        $requestUrl = UrlBuilder::getAccountSettingsUrl(username);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new Settings($reply);
    }

    /**
     * Retrieve settings which are attached to a $device.
     *
     * @param username Username of the account which owns the $device
     * @param $device Name of the targeted $device
     *
     * @return Received settings as key-value-pairs
     */
    public function deviceSettings($username, $device)
    {
        $requestUrl = UrlBuilder::getDeviceSettingsUrl($username, $device);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new Settings($reply);
    }

    /**
     * Retrieve settings which are attached to a podcast.
     *
     * @param username Username of the account which owns the podcast
     * @param podcastUrl Url which identifies the targeted podcast
     *
     * @return Received settings as key-value-pairs
     */
    public function podcastSettings($username, $podcastUrl)
    {
        $requestUrl = UrlBuilder::getPodcastSettingsUrl($username, podcastUrl);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new Settings($reply);
    }

    /**
     * Retrieve settings which are attached to an episode.
     *
     * @param username Username of the account which owns the episode
     * @param podcastUrl Url as String which identifies the podcast to which the episode belongs to
     * @param episodeUrl Url as String which identifies the targeted episode
     *
     * @return Received settings as key-value-pairs
     */
    public function episodeSettings($username, $podcastUrl, $episodeUrl)
    {
        $requestUrl = UrlBuilder::getEpisodeSettingsUrl($username, $podcastUrl, $episodeUrl);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new Settings($reply);
    }

    /**
     * Set and or remove settings which are attached to an account.
     *
     * @param username Username of the targeted account
     * @param set A set of settings as key-value-pairs which shall be set
     * @param set A set of exisiting settings as key-value-pairs which shall be removed
     *
     * @return All settings as key-value-pairs which are stored after the update
     */
    public function setAccountSettings($username, $remove)
    {
        $requestUrl = UrlBuilder::getAccountSettingsUrl($username);
        $postData = JsonCreator::saveSettingsToJSON($set, $remove);
        $reply = $this->requestHandler->getPostRequest($postData, $requestUrl);

        return new Settings($reply);
    }

    /**
     * Set and or remove settings which are attached to a $device.
     *
     * @param username Username of the account which owns the $device
     * @param $device Name of the targeted $device
     * @param set A set of settings as key-value-pairs which shall be set
     * @param set A set of exisiting settings as key-value-pairs which shall be removed
     *
     * @return All settings as key-value-pairs which are stored after the update
     */
    public function setDeviceSettings($username, $device, $set, $remove)
    {
        $requestUrl = UrlBuilder::getDeviceSettingsUrl($username, $device);
        $postData = JsonCreator::saveSettingsToJSON($set, $remove);
        $reply = $this->requestHandler->getPostRequest($postData, $requestUrl);

        return new Settings($reply);
    }

    /**
     * Set and or remove settings which are attached to a podcast.
     *
     * @param username Username of the account which owns the podcast
     * @param podcastUrl Url which identifies the targeted podcast
     * @param set A set of settings as key-value-pairs which shall be set
     * @param set A set of exisiting settings as key-value-pairs which shall be removed
     *
     * @return All settings as key-value-pairs which are stored after the update
     */
    public function setPodcastSettings($username, $podcastUrl, $remove)
    {
        $requestUrl = UrlBuilder::getPodcastSettingsUrl($username, podcastUrl);
        $postData = JsonCreator::saveSettingsToJSON($set, $remove);
        $reply = $this->requestHandler->getPostRequest($postData, $requestUrl);

        return new Settings($reply);
    }

    /**
     * Set and or remove settings which are attached to an episode.
     *
     * @param username Username of the account which owns the episode
     * @param podcastUrl Url as String which identifies the podcast to which the episode belongs to
     * @param episodeUrl Url as String which identifies the targeted episode
     * @param set A set of settings as key-value-pairs which shall be set
     * @param set A set of exisiting settings as key-value-pairs which shall be removed
     *
     * @return All settings as key-value-pairs which are stored after the update
     */
    public function setEpisodeSettings($username, $podcastUrl, $episodeUrl, $remove)
    {
        $requestUrl = UrlBuilder::getEpisodeSettingsUrl($username, podcastUrl, episodeUrl);
        $postData = JsonCreator::saveSettingsToJSON($set, $remove);
        $reply = $this->requestHandler->getPostRequest($postData, $requestUrl);

        return new Settings($reply);
    }

    /**
     * Retrieve episode and subscription updates for a given $device.
     *
     * @param username Username of the account which owns the $device
     * @param $deviceId Id of the targeted $device
     * @param timestamp A date in milliseconds, All changes since this timestamp will be retrieved
     *
     * @return A $deviceUpdatesPtr which accesses:
     *           - a list of subscriptions to be added, with URL, title and descriptions
     *           - a list of URLs to be unsubscribed
     *           - a list of updated episodes
     */
    public function deviceUpdates($username, $deviceId, $timestamp)
    {
        $requestUrl = UrlBuilder::getDeviceUpdatesUrl($username, $deviceId, $timestamp);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return json_decode($reply->body);
    }

    /**
     * Sets a new name and type for a $device identified by a given ID.
     *
     * @param username Username of the account which owns the $device
     * @param $deviceId The id of the targeted $device
     * @param caption The new name of the $device
     * @param type The new type of the    $device
     *
     * @return A Pointer to a QNetworkReply which receives network signals
     */
    public function renameDevice($username, $deviceId, $caption, $type)
    {
        $requestUrl = UrlBuilder::getrenameDeviceUrl($username, $deviceId);
        $data = null;
        switch ($type) {
        case Device::DESKTOP:
            $data = JsonCreator::renameDeviceStringToJSON($caption, 'desktop');
            break;
        case Device::LAPTOP:
            $data = JsonCreator::renameDeviceStringToJSON($caption, 'laptop');
            break;
        case Device::MOBILE:
            $data = JsonCreator::renameDeviceStringToJSON($caption, 'mobile');
            break;
        case Device::SERVER:
            $data = JsonCreator::renameDeviceStringToJSON($caption, 'server');
            break;
        case Device::OTHER:
            $data = JsonCreator::renameDeviceStringToJSON($caption, 'other');
            break;
        }

        return $this->requestHandler->getPostRequest($data, $requestUrl);
    }

    /**
     * Returns the list of $devices that belong to a user.
     *
     * @param username Username of the targeted user
     *
     * @return List of $devices
     */
    public function listDevices($username)
    {
        $requestUrl = UrlBuilder::getDeviceListUrl($username);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new DeviceList($reply);
    }

    /**
     * Download episode actions for a given username.
     *
     * @param Username of the targeted user
     * @param aggregated If aggregated is set to true, only the latest episode action will be returned
     *
     * @return List of all episode actions of the user
     */
    public function episodeActions($username, $aggregated = false)
    {
        $requestUrl = UrlBuilder::getEpisodeActionsUrl($username, $aggregated);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new EpisodeActionList($reply);
    }

    /**
     * Download episode actions for a given podcast.
     *
     * @param username Username of the account which owns the podcast
     * @param podcastUrl Url which identifies the targeted podcast
     * @param aggregated If aggregated is set to true, only the latest episode action will be returned
     *
     * @return List of all episode actions for the given podcast
     */
    public function episodeActionsByPodcast($username, $podcastUrl, $aggregated = false)
    {
        $requestUrl = UrlBuilder::getEpisodeActionsUrlByPodcast($username, $podcastUrl, $aggregated);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new EpisodeActionList($reply);
    }

    /**
     * Download episode actions for a given $device.
     *
     * @param username Username of the account which owns the $device
     * @param $deviceId The Id of the targeted $device
     * @param aggregated If aggregated is set to true, only the latest episode action will be returned
     *
     * @return List of all episode actions for the given $device
     */
    public function episodeActionsByDevice($username, $deviceId, $aggregated = false)
    {
        $requestUrl = UrlBuilder::getEpisodeActionsUrlByDevice($username, $deviceId, $aggregated);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new EpisodeActionList($reply);
    }

    /**
     * Download episode actions for a given username since a given timestamp.
     *
     * @param Username of the targeted user
     * @param since Timestamp in milliseconds, Episode Actions since this time will be retrieved
     *
     * @return List of all new episode actions since the given timestamp
     */
    public function episodeActionsByTimestamp($username, $since)
    {
        $requestUrl = UrlBuilder::getEpisodeActionsUrlByTimestamp($username, $since);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new EpisodeActionList($reply);
    }

    /**
     * Download episode actions for a given podcast since a given timestamp.
     *
     * @param username Username of the account which owns the podcast
     * @param podcastUrl Url which identifies the targeted podcast
     * @param since Timestamp in milliseconds, Episode Actions since this time will be retrieved
     *
     * @return List of all new episode actions since the given timestamp
     */
    public function episodeActionsByPodcastAndTimestamp($username, $podcastUrl, $since)
    {
        $requestUrl = UrlBuilder::getEpisodeActionsUrlByPodcastAndTimestamp($username, $podcastUrl, $since);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new EpisodeActionList($reply);
    }

    /**
     * Download episode actions for a given $device since a given timestamp.
     *
     * @param username Username of the account which owns the $device
     * @param $deviceId The Id of the targeted $device
     * @param since Timestamp in milliseconds, Episode Actions since this time will be retrieved
     *
     * @return List of all new episode actions since the given timestamp
     */
    public function episodeActionsByDeviceAndTimestamp($username, $deviceId, $since)
    {
        $requestUrl = UrlBuilder::getEpisodeActionsUrlByDeviceAndTimestamp($username, $deviceId, $since);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new EpisodeActionList($reply);
    }

    /**
     * Upload episode actions.
     *
     * @param episodeActions The list of episode actions which shall be uploaded
     *
     * @return An AddRemoveResultPtr which contains information about the updated Urls
     */
    public function uploadEpisodeActions($username, $episodeActions)
    {
        $requestUrl = UrlBuilder::getEpisodeActionsUrl($username, false);
        $postData = JsonCreator::episodeActionListToJSON($episodeActions);
        $reply = $this->requestHandler->getPostRequest($postData, $requestUrl);

        return new AddRemoveResult($reply);
    }

    public function deviceSynchronizationStatus($username)
    {
        $requestUrl = UrlBuilder::getDeviceSynchronizationStatusUrl($username);
        $reply = $this->requestHandler->getAuthGetRequest($requestUrl);

        return new DeviceSyncResult($reply);
    }

    public function setDeviceSynchronizationStatus($username, $synchronize, $stopSynchronize)
    {
        $requestUrl = UrlBuilder::getDeviceSynchronizationStatusUrl($username);
        $data = JsonCreator::deviceSynchronizationListsToJSON($synchronize, $stopSynchronize);
        $reply = $this->requestHandler->getPostRequest($data, $requestUrl);

        return new DeviceSyncResult(reply);
    }
}

}
