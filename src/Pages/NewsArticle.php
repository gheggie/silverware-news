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

use SilverStripe\Forms\DateField;
use SilverWare\Extensions\Model\DetailFieldsExtension;
use Page;

/**
 * An extension of the page class for a news article
 *
 * @package SilverWare\News\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-news
 */
class NewsArticle extends Page
{
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'News Article';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'News Articles';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'An individual article within a news category';
    
    /**
     * Icon file for this object.
     *
     * @var string
     * @config
     */
    private static $icon = 'silverware/news: admin/client/dist/images/icons/NewsArticle.png';
    
    /**
     * Defines the default sort field and order for this object.
     *
     * @var string
     * @config
     */
    private static $default_sort = '"Date" DESC';
    
    /**
     * Determines whether this object can exist at the root level.
     *
     * @var boolean
     * @config
     */
    private static $can_be_root = false;
    
    /**
     * Maps field names to field types for this object.
     *
     * @var array
     * @config
     */
    private static $db = [
        'Date' => 'Date'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'ShowInMenus' => 0
    ];
    
    /**
     * Maps field and method names to the class names of casting objects.
     *
     * @var array
     * @config
     */
    private static $casting = [
        'CategoryLink' => 'HTMLFragment'
    ];
    
    /**
     * Defines the allowed children for this object.
     *
     * @var array|string
     * @config
     */
    private static $allowed_children = 'none';
    
    /**
     * Defines the extension classes to apply to this object.
     *
     * @var array
     * @config
     */
    private static $extensions = [
        DetailFieldsExtension::class
    ];
    
    /**
     * Defines the format for the meta date field.
     *
     * @var string
     * @config
     */
    private static $meta_date_format = 'd MMMM Y';
    
    /**
     * Defines the asset folder for uploaded meta images.
     *
     * @var string
     * @config
     */
    private static $meta_image_folder = 'News';
    
    /**
     * Defines the detail fields to show for the object.
     *
     * @var array
     * @config
     */
    private static $detail_fields = [
        'date' => [
            'name' => 'Date',
            'icon' => 'calendar',
            'text' => '$MetaDateFormatted'
        ],
        'category' => [
            'name' => 'Category',
            'icon' => 'folder-o',
            'text' => '$CategoryLink'
        ]
    ];
    
    /**
     * Defines the setting for showing the detail fields inline.
     *
     * @var boolean
     * @config
     */
    private static $detail_fields_inline = true;
    
    /**
     * Defines the setting for hiding the detail fields header.
     *
     * @var boolean
     * @config
     */
    private static $detail_fields_hide_header = true;
    
    /**
     * Defines the setting for hiding the detail field names.
     *
     * @var boolean
     * @config
     */
    private static $detail_fields_hide_names = true;
    
    /**
     * Defines the list item details to show for this object.
     *
     * @var array
     * @config
     */
    private static $list_item_details = [
        'category' => [
            'icon' => 'folder-o',
            'text' => '$CategoryLink'
        ]
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
        
        // Create Main Fields:
        
        $fields->addFieldsToTab(
            'Root.Main',
            [
                DateField::create(
                    'Date',
                    $this->fieldLabel('Date')
                )
            ],
            'Content'
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
        
        $labels['Date'] = _t(__CLASS__ . '.DATE', 'Date');
        $labels['Title'] = _t(__CLASS__ . '.POSTTITLE', 'Article title');
        
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
        
        $this->Date = date('Y-m-d');
    }
    
    /**
     * Answers the meta date for the receiver.
     *
     * @return DBDate
     */
    public function getMetaDate()
    {
        return $this->dbObject('Date');
    }
    
    /**
     * Answers the parent category of the receiver.
     *
     * @return NewsCategory
     */
    public function getCategory()
    {
        return $this->getParent();
    }
    
    /**
     * Answers a string of HTML containing a link to the parent category.
     *
     * @return string
     */
    public function getCategoryLink()
    {
        return sprintf(
            '<a href="%s">%s</a>',
            $this->getCategory()->Link(),
            $this->getCategory()->Title
        );
    }
    
    /**
     * Answers the parent archive of the receiver.
     *
     * @return NewsArchive
     */
    public function getArchive()
    {
        return $this->getCategory()->getParent();
    }
}
