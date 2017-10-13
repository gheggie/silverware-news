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

use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayList;
use SilverWare\Extensions\Lists\ListViewExtension;
use SilverWare\Extensions\Model\ImageDefaultsExtension;
use SilverWare\Forms\FieldSection;
use SilverWare\Forms\ToggleGroup;
use SilverWare\Lists\ListSource;
use Page;

/**
 * An extension of the page class for a news archive.
 *
 * @package SilverWare\News\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-news
 */
class NewsArchive extends Page implements ListSource
{
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'News Archive';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'News Archives';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'Holds a series of news articles organised into categories';
    
    /**
     * Icon file for this object.
     *
     * @var string
     * @config
     */
    private static $icon = 'silverware/news: admin/client/dist/images/icons/NewsArchive.png';
    
    /**
     * Defines the default child class for this object.
     *
     * @var string
     * @config
     */
    private static $default_child = NewsCategory::class;
    
    /**
     * Maps field names to field types for this object.
     *
     * @var array
     * @config
     */
    private static $db = [
        'FeedTitle' => 'Varchar(255)',
        'FeedDescription' => 'Varchar(255)',
        'FeedNumberOfArticles' => 'Int',
        'FeedEnabled' => 'Boolean'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'FeedEnabled' => 1,
        'FeedNumberOfArticles' => 10
    ];
    
    /**
     * Defines the default values for the list view component.
     *
     * @var array
     * @config
     */
    private static $list_view_defaults = [
        'PaginateItems' => 1,
        'ItemsPerPage' => 10
    ];
    
    /**
     * Defines the allowed children for this object.
     *
     * @var array|string
     * @config
     */
    private static $allowed_children = [
        NewsCategory::class
    ];
    
    /**
     * Defines the extension classes to apply to this object.
     *
     * @var array
     * @config
     */
    private static $extensions = [
        ListViewExtension::class,
        ImageDefaultsExtension::class
    ];
    
    /**
     * Answers a list of field objects for the CMS interface.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        // Obtain Field Objects (from parent):
        
        $fields = parent::getCMSFields();
        
        // Create Options Fields:
        
        $fields->addFieldsToTab(
            'Root.Options',
            [
                FieldSection::create(
                    'FeedOptions',
                    $this->fieldLabel('FeedOptions'),
                    [
                        ToggleGroup::create(
                            'FeedEnabled',
                            $this->fieldLabel('FeedEnabled'),
                            [
                                TextField::create(
                                    'FeedTitle',
                                    $this->fieldLabel('FeedTitle')
                                ),
                                TextField::create(
                                    'FeedDescription',
                                    $this->fieldLabel('FeedDescription')
                                ),
                                NumericField::create(
                                    'FeedNumberOfArticles',
                                    $this->fieldLabel('FeedNumberOfArticles')
                                )
                            ]
                        )
                    ]
                )
            ]
        );
        
        // Answer Field Objects:
        
        return $fields;
    }
    
    /**
     * Answers the labels for the fields of the receiver.
     *
     * @param boolean $includerelations Include labels for relations.
     *
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        // Obtain Field Labels (from parent):
        
        $labels = parent::fieldLabels($includerelations);
        
        // Define Field Labels:
        
        $labels['FeedTitle'] = _t(__CLASS__ . '.FEEDTITLE', 'Title');
        $labels['FeedOptions'] = _t(__CLASS__ . '.FEED', 'Feed');
        $labels['FeedEnabled'] = _t(__CLASS__ . '.FEEDENABLED', 'Feed enabled');
        $labels['FeedDescription'] = _t(__CLASS__ . '.DESCRIPTION', 'Description');
        $labels['FeedNumberOfArticles'] = _t(__CLASS__ . '.NUMBEROFARTICLES', 'Number of articles');
        
        // Answer Field Labels:
        
        return $labels;
    }
    
    /**
     * Populates the default values for the fields of the receiver.
     *
     * @return void
     */
    public function populateDefaults()
    {
        // Populate Defaults (from parent):
        
        parent::populateDefaults();
        
        // Populate Defaults:
        
        $this->FeedTitle = _t(
            __CLASS__ . '.DEFAULTFEEDTITLE',
            'Latest News Articles'
        );
        
        $this->FeedDescription = _t(
            __CLASS__ . '.DEFAULTFEEDDESCRIPTION',
            'The latest news articles from our site.'
        );
    }
    
    /**
     * Answers a list of articles within the archive.
     *
     * @return DataList
     */
    public function getArticles()
    {
        return NewsArticle::get()->filter('ParentID', $this->AllChildren()->column('ID') ?: null);
    }
    
    /**
     * Answers a list of articles within the archive for the RSS feed.
     *
     * @return DataList
     */
    public function getFeedArticles()
    {
        return $this->getArticles()->limit($this->FeedNumberOfArticles);
    }
    
    /**
     * Answers a list of articles within the receiver.
     *
     * @return DataList
     */
    public function getListItems()
    {
        return $this->getArticles();
    }
}
