<?php

namespace DMS\Service\Meetup;

use DMS\Service\Meetup\Plugin\RateLimitPlugin;
use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\Operation;
use Guzzle\Service\Description\ServiceDescription;
use DMS\Service\Meetup\Response\SingleResultResponse;
use DMS\Service\Meetup\Response\MultiResultResponse;

/**
 * Class AbstractMeetupClient
 *
 * This is the foundation for the clients that implement proper Authentication methods.
 *
 * @package DMS\Service\Meetup
 *
 * @method SingleResultResponse createBatch(array $args = array())
 * @method SingleResultResponse createEvent(array $args = array())
 * @method SingleResultResponse createEventComment(array $args = array())
 * @method SingleResultResponse createEventCommentFlag(array $args = array())
 * @method SingleResultResponse createEventRating(array $args = array())
 * @method SingleResultResponse createGroupAbuseReports(array $args = array())
 * @method SingleResultResponse createGroupMemberApprovals(array $args = array())
 * @method SingleResultResponse createGroupPhoto(array $args = array())
 * @method SingleResultResponse createGroupTopics(array $args = array())
 * @method SingleResultResponse createGroupVenues(array $args = array())
 * @method SingleResultResponse createMemberPhoto(array $args = array())
 * @method SingleResultResponse createNotificationsRead(array $args = array())
 * @method SingleResultResponse createPhoto(array $args = array())
 * @method SingleResultResponse createPhotoAlbum(array $args = array())
 * @method SingleResultResponse createPhotoComment(array $args = array())
 * @method SingleResultResponse createProfile(array $args = array())
 * @method SingleResultResponse createRecommendedGroupsIgnores(array $args = array())
 * @method SingleResultResponse createRsvp(array $args = array())
 * @method SingleResultResponse createSelfAbuseReports(array $args = array())
 * @method SingleResultResponse createSelfBlocks(array $args = array())
 * @method SingleResultResponse deleteEvent(array $args = array())
 * @method SingleResultResponse deleteEventComment(array $args = array())
 * @method SingleResultResponse deleteEventCommentLike(array $args = array())
 * @method SingleResultResponse deleteEventCommentSubscribe(array $args = array())
 * @method SingleResultResponse deleteGroupEventsWatchlist(array $args = array())
 * @method SingleResultResponse deleteGroupMemberApprovals(array $args = array())
 * @method SingleResultResponse deleteGroupTopics(array $args = array())
 * @method SingleResultResponse deleteMemberPhoto(array $args = array())
 * @method SingleResultResponse deletePhoto(array $args = array())
 * @method SingleResultResponse deleteProfile(array $args = array())
 * @method SingleResultResponse deleteSelfBlocks(array $args = array())
 * @method SingleResultResponse editEvent(array $args = array())
 * @method SingleResultResponse editEventCommentLike(array $args = array())
 * @method SingleResultResponse editEventCommentSubscribe(array $args = array())
 * @method SingleResultResponse editGroup(array $args = array())
 * @method SingleResultResponse editGroupEventsAttendance(array $args = array())
 * @method SingleResultResponse editGroupEventsPayments(array $args = array())
 * @method SingleResultResponse editGroupEventsWatchlist(array $args = array())
 * @method SingleResultResponse editMember(array $args = array())
 * @method SingleResultResponse editProfile(array $args = array())
 * @method MultiResultResponse  getAccessToken(array $args = array())
 * @method MultiResultResponse  getActivity(array $args = array())
 * @method MultiResultResponse  getCategories(array $args = array())
 * @method MultiResultResponse  getCities(array $args = array())
 * @method MultiResultResponse  getComments(array $args = array())
 * @method MultiResultResponse  getConcierge(array $args = array())
 * @method MultiResultResponse  getDashboard(array $args = array())
 * @method SingleResultResponse getEvent(array $args = array())
 * @method SingleResultResponse getEventComment(array $args = array())
 * @method MultiResultResponse  getEventCommentLikes(array $args = array())
 * @method MultiResultResponse  getEventComments(array $args = array())
 * @method MultiResultResponse  getEventCommentsStream(array $args = array())
 * @method MultiResultResponse  getEventRatings(array $args = array())
 * @method MultiResultResponse  getEvents(array $args = array())
 * @method MultiResultResponse  getFindGroups(array $args = array())
 * @method MultiResultResponse  getGroup(array $args = array())
 * @method MultiResultResponse  getGroupBoards(array $args = array())
 * @method MultiResultResponse  getGroupBoardsDiscussions(array $args = array())
 * @method SingleResultResponse getGroupEventsAttendance(array $args = array())
 * @method MultiResultResponse  getGroupSimilarGroups(array $args = array())
 * @method MultiResultResponse  getGroupVenues(array $args = array())
 * @method SingleResultResponse getGroups(array $args = array())
 * @method SingleResultResponse getMember(array $args = array())
 * @method MultiResultResponse  getMembers(array $args = array())
 * @method MultiResultResponse  getNotifications(array $args = array())
 * @method MultiResultResponse  getOembed(array $args = array())
 * @method MultiResultResponse  getOpenEvents(array $args = array())
 * @method MultiResultResponse  getOpenEventsStream(array $args = array())
 * @method MultiResultResponse  getOpenVenues(array $args = array())
 * @method MultiResultResponse  getOpenVenuesStream(array $args = array())
 * @method MultiResultResponse  getPhotoAlbums(array $args = array())
 * @method MultiResultResponse  getPhotoComments(array $args = array())
 * @method MultiResultResponse  getPhotos(array $args = array())
 * @method MultiResultResponse  getPhotosStream(array $args = array())
 * @method MultiResultResponse  getProfile(array $args = array())
 * @method MultiResultResponse  getProfiles(array $args = array())
 * @method MultiResultResponse  getRecommendedGroupTopics(array $args = array())
 * @method MultiResultResponse  getRecommendedGroups(array $args = array())
 * @method MultiResultResponse  getRecommendedVenues(array $args = array())
 * @method MultiResultResponse  getRequestToken(array $args = array())
 * @method SingleResultResponse getRsvp(array $args = array())
 * @method MultiResultResponse  getRsvps(array $args = array())
 * @method MultiResultResponse  getRsvpsStream(array $args = array())
 * @method MultiResultResponse  getSelfBlocks(array $args = array())
 * @method MultiResultResponse  getStatus(array $args = array())
 * @method MultiResultResponse  getTopicCategories(array $args = array())
 * @method MultiResultResponse  getTopics(array $args = array())
 * @method MultiResultResponse  getVenues(array $args = array())
 * @method SingleResultResponse webSocketEventCommentsStream(array $args = array())
 * @method SingleResultResponse webSocketPhotosStream(array $args = array())
 * @method SingleResultResponse webSocketRsvpsStream(array $args = array())
 * @method SingleResultResponse widget(array $args = array())
 * @method SingleResultResponse widgetQuery(array $args = array())
 */
abstract class AbstractMeetupClient extends Client
{
    /**
     * Constructor
     *
     * {@inheritdoc}
     */
    public function __construct($baseUrl = '', $config = null)
    {
        parent::__construct($baseUrl, $config);
    }

    /**
     * Returns the default values for incoming configuration parameters
     *
     * @return array
     */
    public static function getDefaultParameters()
    {
        return array();
    }

    /**
     * Defines the configuration parameters that are required for client
     *
     * @return array
     */
    public static function getRequiredParameters()
    {
        return array();
    }

    /**
     * Builds array of configurations into final config
     *
     * @param array $config
     * @return Collection
     */
    public static function buildConfig($config = array())
    {
        $default  = static::getDefaultParameters();
        $required = static::getRequiredParameters();
        $config = Collection::fromConfig($config, $default, $required);

        $standardHeaders = array(
            'Accept-Charset' => 'utf-8'
        );

        $requestOptions = array(
            'headers' => $standardHeaders,
        );

        $config->add('request.options', $requestOptions);

        return $config;
    }

    /**
     * Loads API method definitions
     *
     * @param \Guzzle\Service\Client $client
     */
    public static function loadDefinitions(Client $client)
    {
        $serviceDescriptions = ServiceDescription::factory(__DIR__ . '/Resources/config/meetup.json');

        foreach ($serviceDescriptions->getOperations() as $operation) {
            /** @var $operation Operation */
            $operation->setClass('DMS\Service\Meetup\Command\MeetupCommand');
        }

        $client->setDescription($serviceDescriptions);
    }

    /**
     * @param Client $client
     * @param $config
     */
    public static function toggleRateLimitingPlugin(Client $client, $config)
    {
        if (array_key_exists('disable_rate_limiting', $config) && $config['disable_rate_limiting']) {
            return;
        }

        $rateFactor = (array_key_exists('rate_limit_factor', $config))? $config['rate_limit_factor'] : null;
        $client->addSubscriber(new RateLimitPlugin($rateFactor));
    }

    /**
     * Shortcut for executing Commands in the Definitions.
     *
     * @param string $method
     * @param array $args
     *
     * @return mixed|void
     *
     */
    public function __call($method, $args)
    {
        $commandName = ucfirst($method);

        return parent::__call($commandName, $args);
    }
}
