<?php

namespace DMS\Service\Meetup;

use Guzzle\Common\Collection;
use Guzzle\Common\Exception\InvalidArgumentException;
use Guzzle\Http\Message\Response;
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
 * @method SingleResultResponse createEvent(array $args = array())
 * @method SingleResultResponse createGroupProfile(array $args = array())
 * @method SingleResultResponse createPhotoAlbum(array $args = array())
 * @method SingleResultResponse deleteEvent(array $args = array())
 * @method SingleResultResponse deleteEventComment(array $args = array())
 * @method SingleResultResponse deleteEventPhoto(array $args = array())
 * @method SingleResultResponse deleteGroupProfile(array $args = array())
 * @method SingleResultResponse deletePhoto(array $args = array())
 * @method SingleResultResponse editEvent(array $args = array())
 * @method SingleResultResponse editGroupProfile(array $args = array())
 * @method SingleResultResponse editMember(array $args = array())
 * @method SingleResultResponse eventCommentSubscribe(array $args = array())
 * @method SingleResultResponse eventCommentUnsubscribe(array $args = array())
 * @method MultiResultResponse getCategories(array $args = array())
 * @method MultiResultResponse getCheckins(array $args = array())
 * @method MultiResultResponse getCheckinsStream(array $args = array())
 * @method SingleResultResponse getCheckinsWebSocketStream(array $args = array())
 * @method MultiResultResponse getChunkedHTTPCheckinsStream(array $args = array())
 * @method MultiResultResponse getChunkedHTTPEventCommentsStream(array $args = array())
 * @method MultiResultResponse getChunkedHTTPOpenVenuesStream(array $args = array())
 * @method MultiResultResponse getChunkedHTTPPhotoStream(array $args = array())
 * @method MultiResultResponse getChunkedHTTPRSVPStream(array $args = array())
 * @method MultiResultResponse getCities(array $args = array())
 * @method MultiResultResponse getConcierge(array $args = array())
 * @method SingleResultResponse getEvent(array $args = array())
 * @method SingleResultResponse getEventComment(array $args = array())
 * @method MultiResultResponse getEventCommentLikes(array $args = array())
 * @method MultiResultResponse getEventComments(array $args = array())
 * @method MultiResultResponse getEventCommentsStream(array $args = array())
 * @method SingleResultResponse getEventCommentsWebSocketStream(array $args = array())
 * @method MultiResultResponse getEventRatings(array $args = array())
 * @method MultiResultResponse getEvents(array $args = array())
 * @method MultiResultResponse getGroupProfile(array $args = array())
 * @method MultiResultResponse getGroupProfiles(array $args = array())
 * @method SingleResultResponse getGroups(array $args = array())
 * @method SingleResultResponse getMember(array $args = array())
 * @method MultiResultResponse getMembers(array $args = array())
 * @method MultiResultResponse getOpenEvents(array $args = array())
 * @method MultiResultResponse getOpenEventsStream(array $args = array())
 * @method MultiResultResponse getOpenVenues(array $args = array())
 * @method MultiResultResponse getPhotoAlbums(array $args = array())
 * @method MultiResultResponse getPhotoComments(array $args = array())
 * @method MultiResultResponse getPhotoStream(array $args = array())
 * @method SingleResultResponse getPhotoWebSocketStream(array $args = array())
 * @method MultiResultResponse getPhotos(array $args = array())
 * @method SingleResultResponse getRSVP(array $args = array())
 * @method MultiResultResponse getRSVPStream(array $args = array())
 * @method SingleResultResponse getRSVPWebSocketStream(array $args = array())
 * @method MultiResultResponse getRSVPs(array $args = array())
 * @method MultiResultResponse getVenues(array $args = array())
 * @method SingleResultResponse postCheckin(array $args = array())
 * @method SingleResultResponse postEventComment(array $args = array())
 * @method SingleResultResponse postEventCommentFlag(array $args = array())
 * @method SingleResultResponse likeEventComment(array $args = array())
 * @method SingleResultResponse postEventPhoto(array $args = array())
 * @method SingleResultResponse postEventRating(array $args = array())
 * @method SingleResultResponse postMemberPhoto(array $args = array())
 * @method SingleResultResponse postMessage(array $args = array())
 * @method SingleResultResponse postPhotoComment(array $args = array())
 * @method SingleResultResponse postRSVP(array $args = array())
 * @method SingleResultResponse unlikeEventComment(array $args = array())
 * @method SingleResultResponse approveMembership(array $args = array())
 * @method SingleResultResponse declineMembership(array $args = array())
 * @method MultiResultResponse findGroups(array $args = array())
 * @method MultiResultResponse getActivityFeed(array $args = array())
 * @method SingleResultResponse getAttendance(array $args = array())
 * @method MultiResultResponse getComments(array $args = array())
 * @method MultiResultResponse getDiscussionBoards(array $args = array())
 * @method MultiResultResponse getDiscussionPosts(array $args = array())
 * @method MultiResultResponse getDiscussions(array $args = array())
 * @method MultiResultResponse getOembed(array $args = array())
 * @method MultiResultResponse getRecommendedGroups(array $args = array())
 * @method MultiResultResponse getTopics(array $args = array())
 * @method SingleResultResponse postAttendance(array $args = array())
 * @method SingleResultResponse createCommunity(array $args = array())
 * @method SingleResultResponse createContainer(array $args = array())
 * @method SingleResultResponse createEWComment(array $args = array())
 * @method SingleResultResponse createEWEvent(array $args = array())
 * @method SingleResultResponse createEventSeed(array $args = array())
 * @method SingleResultResponse deleteCommunity(array $args = array())
 * @method SingleResultResponse deleteEWRSVP(array $args = array())
 * @method SingleResultResponse deleteEventSeed(array $args = array())
 * @method SingleResultResponse editCommunity(array $args = array())
 * @method SingleResultResponse editContainer(array $args = array())
 * @method SingleResultResponse editContainerAlert(array $args = array())
 * @method SingleResultResponse editEWEvent(array $args = array())
 * @method SingleResultResponse editEventSeed(array $args = array())
 * @method SingleResultResponse followCommunity(array $args = array())
 * @method MultiResultResponse getCommunities(array $args = array())
 * @method SingleResultResponse getCommunity(array $args = array())
 * @method SingleResultResponse getCommunityFollow(array $args = array())
 * @method MultiResultResponse getCommunityFollowers(array $args = array())
 * @method MultiResultResponse getCommunityFollows(array $args = array())
 * @method SingleResultResponse getContainer(array $args = array())
 * @method SingleResultResponse getContainerAlerts(array $args = array())
 * @method MultiResultResponse getContainers(array $args = array())
 * @method SingleResultResponse getEWComment(array $args = array())
 * @method SingleResultResponse deleteEWComment(array $args = array())
 * @method MultiResultResponse getEWComments(array $args = array())
 * @method SingleResultResponse getEWEvent(array $args = array())
 * @method MultiResultResponse getEWEvents(array $args = array())
 * @method SingleResultResponse getEWRSVP(array $args = array())
 * @method SingleResultResponse getEventSeed(array $args = array())
 * @method MultiResultResponse getEventSeeds(array $args = array())
 * @method SingleResultResponse postEWRSVP(array $args = array())
 * @method SingleResultResponse unfollowCommunity(array $args = array())
 * @method MultiResultResponse getEWRSVPs(array $args = array())
 */
abstract class AbstractMeetupClient extends Client
{

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
     */
    public static function loadStandardSettings(Client $client)
    {
        //Force UTF-8 MultiResultResponse
        $client->setDefaultHeaders(array('Accept-Charset' => 'utf-8'));

        //Force JSON
//        $client->setDefaultHeaders(array('Accept' => 'application/json'));

        //Enable Magic Method Handling
        $client->enableMagicMethods(true);
    }

    /**
     * Shortcut for executing Commands in the Definitions.
     *
     * @param string $name
     * @param array|null $arguments
     *
     * @return mixed|void
     *
     * @throws InvalidArgumentException
     */
    public function __call($name, $arguments)
    {
        $commandName = ucfirst($name);

        return parent::__call($commandName, $arguments);
    }



}
