<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/App/Extension/Title.php';
require_once 'Zend/Gdata/App/Extension/Content.php';
require_once 'Zend/Gdata/Extension/Rating.php';
require_once 'Zend/Gdata/Query.php';
require_once 'Zend/Gdata/DouBan/PeopleEntry.php';
require_once 'Zend/Gdata/DouBan/PeopleFeed.php';
require_once 'Zend/Gdata/DouBan/BookEntry.php';
require_once 'Zend/Gdata/DouBan/BookFeed.php';
require_once 'Zend/Gdata/DouBan/MusicEntry.php';
require_once 'Zend/Gdata/DouBan/MusicFeed.php';
require_once 'Zend/Gdata/DouBan/MovieEntry.php';
require_once 'Zend/Gdata/DouBan/MovieFeed.php';
require_once 'Zend/Gdata/DouBan/ReviewEntry.php';
require_once 'Zend/Gdata/DouBan/ReviewFeed.php';
require_once 'Zend/Gdata/DouBan/TagEntry.php';
require_once 'Zend/Gdata/DouBan/TagFeed.php';
require_once 'Zend/Gdata/DouBan/CollectionEntry.php';
require_once 'Zend/Gdata/DouBan/CollectionFeed.php';
require_once 'Zend/Gdata/DouBan/BroadcastingEntry.php';
require_once 'Zend/Gdata/DouBan/BroadcastingFeed.php';
require_once 'Zend/Gdata/DouBan/NoteEntry.php';
require_once 'Zend/Gdata/DouBan/NoteFeed.php';
require_once 'Zend/Gdata/DouBan/Subject.php';
require_once 'Zend/Gdata/DouBan/Extension/Attribute.php';
require_once 'Zend/Gdata/client.php';

class Zend_Gdata_DouBan extends Zend_Gdata
{
	const SERVER_URL = 'http://api.douban.com';
	protected $_APIKey = NULL;
	protected $_client = NULL;
	
	public static $namespaces = array(
		'db' => 'http://www.douban.com/xmlns/',
		'gd' => 'http://schemas.google.com/g/2005',
	);
	
	public function __construct($apiKey = NULL, $secret = NULL)
    	{
        	$this->registerPackage('Zend_Gdata_DouBan');
		$this->_client = new OAuthClient($apiKey, $secret);
		$this->_APIKey = $apiKey;
		parent::__construct($this->_client, $this->_APIKey);
    	}
	
	//API authorization
	public function getAuthorizationURL($apiKey = NULL, $secret = NULL, $callback = NULL)
	{
		return $this->_client->getAuthorizationUrl($apiKey, $secret, $callback);
	}
	
	public function getRequestToken()
    {
        return $this->_client->getRequestToken();
    }

	public function getAccessToken($key = NULL, $secret = NULL, $token = NULL)
    {
        return $this->_client->getAccessToken($key, $secret);
    }
	public function programmaticLogin($tokenKey = NULL, $tokenSecret = NULL)
	{
		return $this->_client->login($tokenKey, $tokenSecret);
	}
	
	public function getEntry($url = NULL, $className = NULL)
	{
		$authHeaderArr = $this->_client->getAuthHeader('GET', $url);
		$authHeader = $authHeaderArr[0];
		$headerStr = $authHeaderArr[1];
		$this->_client->clearHeaders();
		if ($authHeader) {
			$this->_httpClient->setHeaders($authHeader);
		} 
	        else if ($this->_APIKey) {
			$param = 'apikey=' . urlencode($this->_APIKey);
			if (stristr($url, '?')) {
				$url = $url . '&' . $param;
			} else {
				$url = $url . '?' . $param;
			}
		}
		return parent::getEntry($url, $className);
	}
	
        public function getFeed($url = NULL, $className = NULL)
	{
		$authHeaderArr = $this->_client->getAuthHeader('GET', $url);
		$authHeader = $authHeaderArr[0];
		$headerStr = $authHeaderArr[1];
		$this->_client->clearHeaders();
		if ($authHeader) {
			$this->_httpClient->setHeaders($authHeader);
		} 
	        else if ($this->_APIKey) {
			$param = 'apikey=' . urlencode($this->_APIKey);
			if (stristr($url, '?')) {
				$url = $url . '&' . $param;
			} else {
				$url = $url . '?' . $param;
			}
		}
		return parent::getFeed($url, $className);
	}
	
	public function post($data, $uri = null, $remainingRedirects = null, 
			$contentType = null, $extraHeaders = null) 
	{
		if ($extraHeaders == NULL) {
			$extraHeaders = array();
		}
		$HeadersArr = $this->_client->getAuthHeader('POST', $uri);
		$Headers = $HeadersArr[0];
		$tmp = array();
		$tmp = array_merge($Headers, $extraHeaders);
		$extraHeaders = $tmp;
		return parent::post($data, $uri, $remainingRedirects, 
			$contentType, $extraHeaders);
	}
	
	public function put($data, $url = NULL, $remainingRedirects = null, 
			$contentType = null, $extraHeaders = null)
	{
		 if ($extraHeaders == NULL) {
                        $extraHeaders = array();
                }
                $HeadersArr = $this->_client->getAuthHeader('PUT', $url);
                $Headers = $HeadersArr[0];
                $tmp = array();
                $tmp = array_merge($Headers, $extraHeaders);
                $extraHeaders = $tmp;
		$this->_httpClient->setHeaders($extraHeaders);
		return parent::put($data, $url, $remainingRedirects, 
			$contentType, $extraHeaders);
	}
	
	public  function delete($url)
	{
		$extraHeadersArr = $this->_client->getAuthHeader('DELETE', $url);
                $extraHeaders = $extraHeadersArr[0];
                $headerStr = $extraHeadersArr[1];
		if (stristr($url, '?')) {
			$url = $url . '&' . $headerStr;
		} else {
			$url = $url . '?' . $headerStr;
		}
		$this->_httpClient->setHeaders($extraHeaders);
		$response = parent::delete($url);

	}

	//people	
	public function getAuthorizedUid()
	{
		$url = self::SERVER_URL . "/people/" . urlencode("@me");
		return $this->getEntry($url, 'Zend_Gdata_DouBan_PeopleEntry');

	}
	
	public function getFriends($uid = NULL)
	{
		if ($uid !== NULL) {
			$url = self::SERVER_URL . "/people/" . $uid . "/friends";
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_PeopleFeed');
	}
	
	public function getContacts($uid = NULL)
	{
		if ($uid !== NULL) {
			$url = self::SERVER_URL . "/people/" . $uid . "/contacts";
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_PeopleFeed');
	}

	public function getPeople($peopleId = NULL, $location = NULL)
	{
		if ($peopleId !== NULL) {
			$url = self::SERVER_URL . "/people/" . $peopleId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_PeopleEntry');
	}

	public function getPeopleFeed($location = NULL)
	{
		if ($location == NULL) {
			$url = self::SERVER_URI . "/people";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_PeopleFeed');
	}
	
	public function searchPeople($queryText, $startIndex = NULL, $maxResults = NULL)
	{
		$query =new Zend_Gdata_Query(self::SERVER_URL . "/people/");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getPeopleFeed($query);
		
	}
	
	//book	
	public function getBook($bookId = NULL, $location = NULL)
	{
		if ($bookId !== NULL) {
			$url = self::SERVER_URL . "/book/subject/" . $bookId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_BookEntry');
	}

	public function getBookFeed($location = NULL)
	{
		if ($location == NULL) {
			$url = self::PEOPLE_URI . "/book/subjects";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_BookFeed');
	}
	
	public function searchBook($queryText, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/book/subjects");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getBookFeed($query);
		
	}
	
	public function queryBookByTag($tag, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/book/subjects");
		$query->setParam('tag', $tag);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getBookFeed($query);
	
	}
	
	//music
	public function getMusic($musicId = NULL, $location = NULL)
	{
		if ($musicId !== NULL) {
			$url = self::SERVER_URL . "/music/subject/" . $musicId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_MusicEntry');
	}

	public function getMusicFeed($location = NULL)
	{
		if ($location == NULL) {
			$url = self::PEOPLE_URI . "/music/subjects";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_MusicFeed');
	}
	
	public function searchMusic($queryText, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/music/subjects");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMusicFeed($query);
		
	}
	
	public function queryMusicByTag($tag, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/music/subjects");
		$query->setParam('tag', $tag);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMusicFeed($query);
	
	}
	
	//movie
	public function getMovie($movieId = NULL, $location = NULL)
	{
		if ($movieId !== NULL) {
			$url = self::SERVER_URL . "/movie/subject/" . $movieId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_MovieEntry');
	}

	public function getMovieFeed($location = NULL)
	{
		if ($location == NULL) {
			$url = self::PEOPLE_URL . "/movie/subjects";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_MovieFeed');
	}
	
	public function searchMovie($queryText, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/movie/subjects");
		$query->setQuery($queryText);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMovieFeed($query);
		
	}
	
	public function queryMovieByTag($tag, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/movie/subjects");
		$query->setParam('tag', $tag);
		$query->setMaxResults($maxResults);
		$query->setStartIndex($startIndex);
		return $this->getMovieFeed($query);
	
	}

	//tags
	public function getTagFeed($category = NULL, $subjectId = NULL)
	{
		if (($subjectId != NULL) && ($category != NULL)) {
			$url = self::SERVER_URL . "/" . $category . "/subject/" . 
				$subjectId . "/tags";
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_TagFeed');
	}
	
	//review
	public function getReview($reviewId = NULL, $location = NULL)
	{
		if ($reviewId !== NULL) {
			$url = self::SERVER_URL . "/review/" . $reviewId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_ReviewEntry');
	}
	
	public function getReviewFeed($subjectId = NULL, $cat = NULL, $orderby = "score")
	{
		if (($subjectId != NULL) && ($cat != NULL))
		{
			$url = self::SERVER_URL . "/" . $cat . "/subject/" . 
				$subjectId . "/reviews";
			$query = new Zend_Gdata_Query($url);
			$query->setParam("orderby", $orderby);
		}
		return $this->getFeed($query->getQueryUrl(), 'Zend_Gdata_DouBan_ReviewFeed');
	}

	public function getMyReview($myId = NULL, $location = NULL)
	{
		if ($myId != NULL) {
			$url = self::SERVER_URL . "/people/" . $myId . "/reviews";
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_ReviewFeed');
	}
	
	public function createReview($title = NULL, $content = NULL, $subject = NULL, 
			$rating = NULL)
	{
		$subId =  $subject->getId();
		$subRating =  $subject->getRating();
		$subject = new Zend_Gdata_DouBan_Subject();
		$subject->setId($subId);
		$subject->setRating($subRating);
		$entry = new Zend_Gdata_DouBan_ReviewEntry();
		$entry->setSubject($subject);
		if ($rating) {
			$rating = new Zend_Gdata_DouBan_Extension_Rating($rating);
			$entry->setRating($rating);
		}
		$title = new Zend_Gdata_App_Extension_Title($title);
		$content = new Zend_Gdata_App_Extension_Content($content);
		$entry->setContent($content);
		$entry->setTitle($title);
		$url = self::SERVER_URL . "/reviews";
		$response =  $this->post($entry, $url, NULL, "application/atom+xml; charset=utf-8");
                $result = new Zend_Gdata_DouBan_ReviewEntry();
                $result->transferFromXML($response->getBody());
                return $result;

	}

	public function updateReview($entry = NULL, $title = NULL, $content = NULL, $rating = NULL)
	{
		$title = new Zend_Gdata_App_Extension_Title($title);
                $content = new Zend_Gdata_App_Extension_Content($content);
                $entry->setContent($content);
                $entry->setTitle($title);
		if ($rating) {
			$rating = new Zend_Gdata_DouBan_Extension_Rating($rating);
                        $entry->setRating($rating);
                }
		$response =  $this->put($entry, $entry->getId()->getText(), 
				NULL, "application/atom+xml; charset=utf-8");
		$result = new Zend_Gdata_DouBan_ReviewEntry();
                $result->transferFromXML($response->getBody());
		return $result;

	}
	
	public function deleteReview($entry)
	{
		$url = $entry->getId()->getText();
		return $this->delete($url);
	}

	//collection
#	public function getCollection($collectionId = NULL, $location = NULL)
#	{
	public function getCollection($url = NULL)
	{
		#if ($collectionId !== NULL) {
                #        $url = self::SERVER_URL . "/collection/" . $collectionId;
                #} else if ($location instanceof Zend_Gdata_Query) {
                #        $url = $location->getQueryUrl();
                #} else {
                #        $url = $location;
                #}
                return $this->getEntry($url, 'Zend_Gdata_DouBan_CollectionEntry');

	}
	
	public function getMyCollection($uid, $cat, $tag, $status = NULL, $startIndex = NULL, 
			$maxResults = NULL, $updatedMax = NULL, $updatedMin = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/people/" . $uid . "/collection");
                if ($tag) $query->setParam('tag', $tag);
                if ($cat) $query->setParam('cat', $cat);
		if ($status) $query->setParam('status', $status);
                if ($maxResults) $query->setMaxResults($maxResults);
                if ($startIndex) $query->setStartIndex($startIndex);
                return $this->getFeed($query->getQueryUrl(), 'Zend_Gdata_DouBan_CollectionFeed');	
	}

	public function getCollectionFeed($peopleId = NULL, $cat = NULL)
	{
		if ($peopleId !== NULL) {
			$url = self::SERVER_URL . "/people/" . $peopleId . 
				"/collection?cat=" . $cat;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getFeed($url, 'Zend_Gdata_DouBan_CollectionFeed');

	}
	
	public function addCollection($status = NULL, $subject = NULL, $rating = NULL, 
			$tags = array(), $private = False)
	{
		$subId =  $subject->getId();
		$subject = new Zend_Gdata_DouBan_Subject();
                $subject->setId($subId);
                $entry = new Zend_Gdata_DouBan_CollectionEntry();
                $entry->setSubject($subject);
		if ($rating) {
                        $rating = new Zend_Gdata_DouBan_Extension_Rating($rating);
                        $entry->setRating($rating);
                }
		if ($private) {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("private");
			$attribute->setName("privacy");
			$entry->setAttribute($attribute);
		}
		else {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("private");
			$attribute->setName("public");
			$entry->setAttribute($attribute);
		}
		foreach ($tags as $tag) {
			$obj = new Zend_Gdata_DouBan_Extension_Tag();
			$obj->setName($tag);
			$entry->setTag($obj);
		}
		$status = new Zend_Gdata_DouBan_Extension_Status($status);
		$entry->setStatus($status);
		$url = self::SERVER_URL . "/collection";
		$response = $this->post($entry, $url, NULL, "application/atom+xml; charset=utf-8");
		$result = new Zend_Gdata_DouBan_CollectionEntry();
		$result->transferFromXML($response->getRawBody());
		return $result;

	}
	
	public function updateCollection($entry = NULL, $status = NULL, $tags = array(), 
			$rating = NULL, $private = False)
	{
		$status = new Zend_Gdata_DouBan_Extension_Status($status);
		$entry->setStatus($status);
		if ($rating) {
			$rating = new Zend_Gdata_DouBan_Extension_Rating($rating);
                        $entry->setRating($rating);
		}
		if ($tags) {
         	       	foreach ($tags as $tag) {
                        	$obj = new Zend_Gdata_DouBan_Extension_Tag();
                        	$obj->setName($tag);
				$entry->setTag($obj);
                	}
	
		}
		if ($private) {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("private");
			$attribute->setName("privacy");
			$entry->setAttribute($attribute);
		}
		else {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("private");
			$attribute->setName("public");
			$entry->setAttribute($attribute);
		}
		$response =  $this->put($entry, $entry->getId()->getText(), NULL,  
				"application/atom+xml; charset=utf-8");
                $result = new Zend_Gdata_DouBan_CollectionEntry();
                $result->transferFromXML($response->getBody());
                return $result;


	}
	
	public function deleteCollection($entry = NULL)
	{
		$url = $entry->getId()->getText();
                return $this->delete($url);
	}

	//Broadcasting
	public function getBroadcastingFeed($userID = NULL,  $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/people/" . 
				$userID . "/miniblog");
		if ($maxResults) {
			$query->setMaxResults($maxResults);
		}
		if ($startIndex) {
			$query->setStartIndex($startIndex);
		}
		return $this->getFeed($query->getQueryUrl(), 'Zend_Gdata_DouBan_BroadcastingFeed');
	}

	public function getContactsBroadcastingFeed($userID = NULL,  $startIndex = NULL, 
			$maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/people/" . 
			$userID . "/miniblog/contacts");
		if ($maxResults) {
			$query->setMaxResults($maxResults);
		}
		if ($startIndex) {
			$query->setStartIndex($startIndex);
		}
		return $this->getFeed($query->getQueryUrl(), 'Zend_Gdata_DouBan_BroadcastingFeed');
	}
	
	public function addBroadcasting($category = NULL, $entry = NULL)
	{
		$url = self::SERVER_URL . "/miniblog/" . $category;
		$response = $this->post($entry, $url, NULL, "application/atom+xml; charset=utf-8");
		$result = new Zend_Gdata_DouBan_BroadcastingEntry();
		$result->transferFromXML($response->getRawBody());
		return $result;
	}

	 public function deleteBroadcasting($entry)
        {
                $url = $entry->getId()->getText();
                return $this->delete($url);
        }

	public function getNote($noteId = NULL, $location = NULL)
	{
		if ($noteId !== NULL) {
			$url = self::SERVER_URL . "/note/" . $noteId;
		} else if ($location instanceof Zend_Gdata_Query) {
			$url = $location->getQueryUrl();
		} else {
			$url = $location;
		}
		return $this->getEntry($url, 'Zend_Gdata_DouBan_NoteEntry');
	}

	public function getMyNotes($uid, $startIndex = NULL, $maxResults = NULL)
	{
		$query = new Zend_Gdata_Query(self::SERVER_URL . "/people/" . $uid . "/notes");
                $query->setMaxResults($maxResults);
                $query->setStartIndex($startIndex);
		return $this->getFeed($query->getQueryUrl(), 'Zend_Gdata_DouBan_NoteFeed');

	}
	
	public function addNote($entry, $private = False, $canReply = True)
	{
		if ($private) {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("private");
			$attribute->setName("privacy");
			$entry->setAttribute($attribute);
		}
		else {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("public");
			$attribute->setName("privacy");
			$entry->setAttribute($attribute);
		}
		if ($canReply) {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("yes");
			$attribute->setName("can_reply");
			$entry->setAttribute($attribute);
		}
		else {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("no");
                        $attribute->setName("can_reply");
                        $entry->setAttribute($attribute);
		}
				
		$url = self::SERVER_URL . "/notes";
		$response = $this->post($entry, $url, NULL, "application/atom+xml; charset=utf-8");
		$result = new Zend_Gdata_DouBan_NoteEntry();
		$result->transferFromXML($response->getRawBody());
		return $result;
	}
	
	public function updateNote($entry = NULL, $title, $content, $private = NULL, $canReply = NULL)
	{
		$title = new Zend_Gdata_App_Extension_Title($title);
                $content = new Zend_Gdata_App_Extension_Content($content);
                $entry->setContent($content);
                $entry->setTitle($title);
		if ($private) {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("private");
			$attribute->setName("privacy");
			$entry->setAttribute($attribute);
		}
		else {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("public");
			$attribute->setName("privacy");
			$entry->setAttribute($attribute);
		}
		if ($canReply) {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("yes");
			$attribute->setName("can_reply");
			$entry->setAttribute($attribute);
		}
		else {
			$attribute = new Zend_Gdata_DouBan_Extension_Attribute("no");
                        $attribute->setName("can_reply");
                        $entry->setAttribute($attribute);
		}
		$response =  $this->put($entry, $entry->getId()->getText(), 
				NULL, "application/atom+xml; charset=utf-8");
		$result = new Zend_Gdata_DouBan_NoteEntry();
                $result->transferFromXML($response->getBody());
		return $result;
	}

	public function deleteNote($entry)
        {
                $url = $entry->getId()->getText();
                return $this->delete($url);
        }
}
?>
