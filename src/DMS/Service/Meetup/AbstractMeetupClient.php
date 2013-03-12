<?php

namespace DMS\Service\Meetup;

use Guzzle\Common\Collection;
use Guzzle\Common\Exception\InvalidArgumentException;
use Guzzle\Http\Message\Response;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

/**
 * Class AbstractMeetupClient
 *
 * This is the foundation for the clients that implement proper Authentication methods.
 *
 * @package DMS\Service\Meetup
 *
 * @method \Guzzle\Http\Message\Response createEvent(array $args = array())
 * @method \Guzzle\Http\Message\Response createGroupProfile(array $args = array())
 * @method \Guzzle\Http\Message\Response createPhotoAlbum(array $args = array())
 * @method \Guzzle\Http\Message\Response deleteEvent(array $args = array())
 * @method \Guzzle\Http\Message\Response deleteEventComment(array $args = array())
 * @method \Guzzle\Http\Message\Response deleteEventPhoto(array $args = array())
 * @method \Guzzle\Http\Message\Response deleteGroupProfile(array $args = array())
 * @method \Guzzle\Http\Message\Response deletePhoto(array $args = array())
 * @method \Guzzle\Http\Message\Response editEvent(array $args = array())
 * @method \Guzzle\Http\Message\Response editGroupProfile(array $args = array())
 * @method \Guzzle\Http\Message\Response editMember(array $args = array())
 * @method \Guzzle\Http\Message\Response eventCommentSubscribe(array $args = array())
 * @method \Guzzle\Http\Message\Response eventCommentUnsubscribe(array $args = array())
 * @method \Guzzle\Http\Message\Response getCategories(array $args = array())
 * @method \Guzzle\Http\Message\Response getCheckins(array $args = array())
 * @method \Guzzle\Http\Message\Response getCheckinsStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getCheckinsWebSocketStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getChunkedHTTPCheckinsStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getChunkedHTTPEventCommentsStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getChunkedHTTPOpenVenuesStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getChunkedHTTPPhotoStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getChunkedHTTPRSVPStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getCities(array $args = array())
 * @method \Guzzle\Http\Message\Response getConcierge(array $args = array())
 * @method \Guzzle\Http\Message\Response getEvent(array $args = array())
 * @method \Guzzle\Http\Message\Response getEventComment(array $args = array())
 * @method \Guzzle\Http\Message\Response getEventCommentLikes(array $args = array())
 * @method \Guzzle\Http\Message\Response getEventComments(array $args = array())
 * @method \Guzzle\Http\Message\Response getEventCommentsStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getEventCommentsWebSocketStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getEventRatings(array $args = array())
 * @method \Guzzle\Http\Message\Response getEvents(array $args = array())
 * @method \Guzzle\Http\Message\Response getGroupProfile(array $args = array())
 * @method \Guzzle\Http\Message\Response getGroupProfiles(array $args = array())
 * @method \Guzzle\Http\Message\Response getGroups(array $args = array())
 * @method \Guzzle\Http\Message\Response getMember(array $args = array())
 * @method \Guzzle\Http\Message\Response getMembers(array $args = array())
 * @method \Guzzle\Http\Message\Response getOpenEvents(array $args = array())
 * @method \Guzzle\Http\Message\Response getOpenEventsStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getOpenVenues(array $args = array())
 * @method \Guzzle\Http\Message\Response getPhotoAlbums(array $args = array())
 * @method \Guzzle\Http\Message\Response getPhotoComments(array $args = array())
 * @method \Guzzle\Http\Message\Response getPhotoStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getPhotoWebSocketStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getPhotos(array $args = array())
 * @method \Guzzle\Http\Message\Response getRSVP(array $args = array())
 * @method \Guzzle\Http\Message\Response getRSVPStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getRSVPWebSocketStream(array $args = array())
 * @method \Guzzle\Http\Message\Response getRSVPs(array $args = array())
 * @method \Guzzle\Http\Message\Response getVenues(array $args = array())
 * @method \Guzzle\Http\Message\Response postCheckin(array $args = array())
 * @method \Guzzle\Http\Message\Response postEventComment(array $args = array())
 * @method \Guzzle\Http\Message\Response postEventCommentFlag(array $args = array())
 * @method \Guzzle\Http\Message\Response likeEventComment(array $args = array())
 * @method \Guzzle\Http\Message\Response postEventPhoto(array $args = array())
 * @method \Guzzle\Http\Message\Response postEventRating(array $args = array())
 * @method \Guzzle\Http\Message\Response postMemberPhoto(array $args = array())
 * @method \Guzzle\Http\Message\Response postMessage(array $args = array())
 * @method \Guzzle\Http\Message\Response postPhotoComment(array $args = array())
 * @method \Guzzle\Http\Message\Response postRSVP(array $args = array())
 * @method \Guzzle\Http\Message\Response unlikeEventComment(array $args = array())
 * @method \Guzzle\Http\Message\Response approveMembership(array $args = array())
 * @method \Guzzle\Http\Message\Response declineMembership(array $args = array())
 * @method \Guzzle\Http\Message\Response findGroups(array $args = array())
 * @method \Guzzle\Http\Message\Response getActivityFeed(array $args = array())
 * @method \Guzzle\Http\Message\Response getAttendance(array $args = array())
 * @method \Guzzle\Http\Message\Response getComments(array $args = array())
 * @method \Guzzle\Http\Message\Response getDiscussionBoards(array $args = array())
 * @method \Guzzle\Http\Message\Response getDiscussionPosts(array $args = array())
 * @method \Guzzle\Http\Message\Response getDiscussions(array $args = array())
 * @method \Guzzle\Http\Message\Response getOembed(array $args = array())
 * @method \Guzzle\Http\Message\Response getRecommendedGroups(array $args = array())
 * @method \Guzzle\Http\Message\Response getTopics(array $args = array())
 * @method \Guzzle\Http\Message\Response postAttendance(array $args = array())
 * @method \Guzzle\Http\Message\Response createCommunity(array $args = array())
 * @method \Guzzle\Http\Message\Response createContainer(array $args = array())
 * @method \Guzzle\Http\Message\Response createEWComment(array $args = array())
 * @method \Guzzle\Http\Message\Response createEWEvent(array $args = array())
 * @method \Guzzle\Http\Message\Response createEventSeed(array $args = array())
 * @method \Guzzle\Http\Message\Response deleteCommunity(array $args = array())
 * @method \Guzzle\Http\Message\Response deleteEWRSVP(array $args = array())
 * @method \Guzzle\Http\Message\Response deleteEventSeed(array $args = array())
 * @method \Guzzle\Http\Message\Response editCommunity(array $args = array())
 * @method \Guzzle\Http\Message\Response editContainer(array $args = array())
 * @method \Guzzle\Http\Message\Response editContainerAlert(array $args = array())
 * @method \Guzzle\Http\Message\Response editEWEvent(array $args = array())
 * @method \Guzzle\Http\Message\Response editEventSeed(array $args = array())
 * @method \Guzzle\Http\Message\Response followCommunity(array $args = array())
 * @method \Guzzle\Http\Message\Response getCommunities(array $args = array())
 * @method \Guzzle\Http\Message\Response getCommunity(array $args = array())
 * @method \Guzzle\Http\Message\Response getCommunityFollow(array $args = array())
 * @method \Guzzle\Http\Message\Response getCommunityFollowers(array $args = array())
 * @method \Guzzle\Http\Message\Response getCommunityFollows(array $args = array())
 * @method \Guzzle\Http\Message\Response getContainer(array $args = array())
 * @method \Guzzle\Http\Message\Response getContainerAlerts(array $args = array())
 * @method \Guzzle\Http\Message\Response getContainers(array $args = array())
 * @method \Guzzle\Http\Message\Response getEWComment(array $args = array())
 * @method \Guzzle\Http\Message\Response deleteEWComment(array $args = array())
 * @method \Guzzle\Http\Message\Response getEWComments(array $args = array())
 * @method \Guzzle\Http\Message\Response getEWEvent(array $args = array())
 * @method \Guzzle\Http\Message\Response getEWEvents(array $args = array())
 * @method \Guzzle\Http\Message\Response getEWRSVP(array $args = array())
 * @method \Guzzle\Http\Message\Response getEventSeed(array $args = array())
 * @method \Guzzle\Http\Message\Response getEventSeeds(array $args = array())
 * @method \Guzzle\Http\Message\Response postEWRSVP(array $args = array())
 * @method \Guzzle\Http\Message\Response unfollowCommunity(array $args = array())
 * @method \Guzzle\Http\Message\Response getEWRSVPs(array $args = array())
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

        $client->setDescription($serviceDescriptions);
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

        $command = $this->getCommand($commandName, $arguments[0]);
        $command->prepare();

        return $command->execute();
    }


}
