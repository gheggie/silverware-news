<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\News\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-news
 */

namespace SilverWare\News\Pages;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\RSS\RSSFeed;
use PageController;

/**
 * An extension of the page controller class for a news archive controller.
 *
 * @package SilverWare\News\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-news
 */
class NewsArchiveController extends PageController
{
    /**
     * Defines the allowed actions for this controller.
     *
     * @var array
     * @config
     */
    private static $allowed_actions = [
        'rss'
    ];
    
    /**
     * Renders a list of the latest news articles as an RSS feed.
     *
     * @param HTTPRequest $request
     *
     * @return DBHTMLText
     */
    public function rss(HTTPRequest $request)
    {
        // Answer 404 (if disabled):
        
        if (!$this->FeedEnabled) {
            return $this->httpError(404);
        }
        
        // Create Feed Object:
        
        $rss = RSSFeed::create(
            $this->getFeedArticles(),
            $this->Link(),
            $this->FeedTitle,
            $this->FeedDescription
        );
        
        // Output Feed Data:
        
        return $rss->outputToBrowser();
    }
    
    /**
     * Performs initialisation before any action is called on the receiver.
     *
     * @return void
     */
    protected function init()
    {
        // Initialise Parent:
        
        parent::init();
        
        // Create Feed Link (if enabled):
        
        if ($this->FeedEnabled) {
            RSSFeed::linkToFeed($this->Link('rss'), $this->FeedTitle);
        }
    }
}
