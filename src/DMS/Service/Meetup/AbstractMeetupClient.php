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
 * @method array createEvent(array $args = array())
 * @method array createGroupProfile(array $args = array())
 * @method array createPhotoAlbum(array $args = array())
 * @method array deleteEvent(array $args = array())
 * @method array deleteEventComment(array $args = array())
 * @method array deleteEventPhoto(array $args = array())
 * @method array deleteGroupProfile(array $args = array())
 * @method array deletePhoto(array $args = array())
 * @method array editEvent(array $args = array())
 * @method array editGroupProfile(array $args = array())
 * @method array editMember(array $args = array())
 * @method array eventCommentSubscribe(array $args = array())
 * @method array eventCommentUnsubscribe(array $args = array())
 * @method array getCategories(array $args = array())
 * @method array getCheckins(array $args = array())
 * @method array getCheckinsStream(array $args = array())
 * @method array getCheckinsWebSocketStream(array $args = array())
 * @method array getChunkedHTTPCheckinsStream(array $args = array())
 * @method array getChunkedHTTPEventCommentsStream(array $args = array())
 * @method array getChunkedHTTPOpenVenuesStream(array $args = array())
 * @method array getChunkedHTTPPhotoStream(array $args = array())
 * @method array getChunkedHTTPRSVPStream(array $args = array())
 * @method array getCities(array $args = array())
 * @method array getConcierge(array $args = array())
 * @method array getEvent(array $args = array())
 * @method array getEventComment(array $args = array())
 * @method array getEventCommentLikes(array $args = array())
 * @method array getEventComments(array $args = array())
 * @method array getEventCommentsStream(array $args = array())
 * @method array getEventCommentsWebSocketStream(array $args = array())
 * @method array getEventRatings(array $args = array())
 * @method array getEvents(array $args = array())
 * @method array getGroupProfile(array $args = array())
 * @method array getGroupProfiles(array $args = array())
 * @method array getGroups(array $args = array())
 * @method array getMember(array $args = array())
 * @method array getMembers(array $args = array())
 * @method array getOpenEvents(array $args = array())
 * @method array getOpenEventsStream(array $args = array())
 * @method array getOpenVenues(array $args = array())
 * @method array getPhotoAlbums(array $args = array())
 * @method array getPhotoComments(array $args = array())
 * @method array getPhotoStream(array $args = array())
 * @method array getPhotoWebSocketStream(array $args = array())
 * @method array getPhotos(array $args = array())
 * @method array getRSVP(array $args = array())
 * @method array getRSVPStream(array $args = array())
 * @method array getRSVPWebSocketStream(array $args = array())
 * @method array getRSVPs(array $args = array())
 * @method array getVenues(array $args = array())
 * @method array postCheckin(array $args = array())
 * @method array postEventComment(array $args = array())
 * @method array postEventCommentFlag(array $args = array())
 * @method array likeEventComment(array $args = array())
 * @method array postEventPhoto(array $args = array())
 * @method array postEventRating(array $args = array())
 * @method array postMemberPhoto(array $args = array())
 * @method array postMessage(array $args = array())
 * @method array postPhotoComment(array $args = array())
 * @method array postRSVP(array $args = array())
 * @method array unlikeEventComment(array $args = array())
 * @method array approveMembership(array $args = array())
 * @method array declineMembership(array $args = array())
 * @method array findGroups(array $args = array())
 * @method array getActivityFeed(array $args = array())
 * @method array getAttendance(array $args = array())
 * @method array getComments(array $args = array())
 * @method array getDiscussionBoards(array $args = array())
 * @method array getDiscussionPosts(array $args = array())
 * @method array getDiscussions(array $args = array())
 * @method array getOembed(array $args = array())
 * @method array getRecommendedGroups(array $args = array())
 * @method array getTopics(array $args = array())
 * @method array postAttendance(array $args = array())
 * @method array createCommunity(array $args = array())
 * @method array createContainer(array $args = array())
 * @method array createEWComment(array $args = array())
 * @method array createEWEvent(array $args = array())
 * @method array createEventSeed(array $args = array())
 * @method array deleteCommunity(array $args = array())
 * @method array deleteEWRSVP(array $args = array())
 * @method array deleteEventSeed(array $args = array())
 * @method array editCommunity(array $args = array())
 * @method array editContainer(array $args = array())
 * @method array editContainerAlert(array $args = array())
 * @method array editEWEvent(array $args = array())
 * @method array editEventSeed(array $args = array())
 * @method array followCommunity(array $args = array())
 * @method array getCommunities(array $args = array())
 * @method array getCommunity(array $args = array())
 * @method array getCommunityFollow(array $args = array())
 * @method array getCommunityFollowers(array $args = array())
 * @method array getCommunityFollows(array $args = array())
 * @method array getContainer(array $args = array())
 * @method array getContainerAlerts(array $args = array())
 * @method array getContainers(array $args = array())
 * @method array getEWComment(array $args = array())
 * @method array deleteEWComment(array $args = array())
 * @method array getEWComments(array $args = array())
 * @method array getEWEvent(array $args = array())
 * @method array getEWEvents(array $args = array())
 * @method array getEWRSVP(array $args = array())
 * @method array getEventSeed(array $args = array())
 * @method array getEventSeeds(array $args = array())
 * @method array postEWRSVP(array $args = array())
 * @method array unfollowCommunity(array $args = array())
 * @method array getEWRSVPs(array $args = array())
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
