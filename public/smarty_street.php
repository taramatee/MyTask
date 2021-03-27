<?php

require_once(dirname(__FILE__) . '/smartystreets-php-sdk/src/ClientBuilder.php');
require_once(dirname(__FILE__) . '/smartystreets-php-sdk/src/US_Street/Lookup.php');
require_once(dirname(__FILE__) . '/smartystreets-php-sdk/src/StaticCredentials.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;

$lookupExample = new UsStreetSingleAddressExample();
$lookupExample->run();

class UsStreetSingleAddressExample {

    public function run() {
        $authId = 'b05d38d1-7da7-d902-4581-5881f48f7d5c';
        $authToken = '3lZxdrQbsPZapyrTzhCr';

        // We recommend storing your secret keys in environment variables instead---it's safer!
//        $authId = getenv('SMARTY_AUTH_ID');
//        $authToken = getenv('SMARTY_AUTH_TOKEN');

        $staticCredentials = new StaticCredentials($authId, $authToken);
        $client = (new ClientBuilder($staticCredentials))
//                        ->viaProxy("http://localhost:8080", "username", "password") // uncomment this line to point to the specified proxy.
                        ->buildUsStreetApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/us-street-api

        $lookup = new Lookup();
        $lookup->setInputId("24601"); // Optional ID from your system
        $lookup->setAddressee("John Doe");
        $lookup->setStreet("1600 Amphitheatre Pkwy");
        $lookup->setStreet2("closet under the stairs");
        $lookup->setSecondary("APT 2");
        $lookup->setUrbanization("");  // Only applies to Puerto Rico addresses
        $lookup->setCity("Mountain View");
        $lookup->setState("CA");
        $lookup->setZipcode("21229");
        $lookup->setMaxCandidates(3);
        $lookup->setMatchStrategy("invalid"); // "invalid" is the most permissive match,
                                                           // this will always return at least one result even if the address is invalid.
                                                           // Refer to the documentation for additional MatchStrategy options.

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        }
        catch (SmartyException $ex) {
            echo($ex->getMessage());
        }
        catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup) {
        $results = $lookup->getResult();

        if (empty($results)) {
            echo("\nNo candidates. This means the address is not valid.");
            return;
        }

        $firstCandidate = $results[0];

        echo("\nAddress is valid. (There is at least one candidate)\n");
        echo("\nZIP Code: " . $firstCandidate->getComponents()->getZIPCode());
        echo("\nCounty: " . $firstCandidate->getMetadata()->getCountyName());
        echo("\nLatitude: " . $firstCandidate->getMetadata()->getLatitude());
        echo("\nLongitude: " . $firstCandidate->getMetadata()->getLongitude());
    }
}