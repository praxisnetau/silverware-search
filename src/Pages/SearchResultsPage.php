<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Search\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-search
 */

namespace SilverWare\Search\Pages;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DB;
use SilverStripe\Versioned\Versioned;
use SilverWare\Forms\FieldSection;
use Page;

/**
 * An extension of the page class for a search results page.
 *
 * @package SilverWare\Search\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-search
 */
class SearchResultsPage extends Page
{
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'Search Results Page';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'Search Results Pages';
    
    /**
     * Icon file for this object.
     *
     * @var string
     * @config
     */
    private static $icon = 'silverware/search: admin/client/dist/images/icons/SearchResultsPage.png';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'A dedicated page for showing search results';
    
    /**
     * Maps field names to field types for this object.
     *
     * @var array
     * @config
     */
    private static $db = [
        'PagesMessage' => 'Varchar(255)',
        'ResultsMessage' => 'Varchar(255)',
        'NoResultsMessage' => 'Varchar(255)',
        'ResultsPerPage' => 'AbsoluteInt',
        'ShowAbsoluteURL' => 'Boolean',
        'ShowSummary' => 'Boolean',
        'SearchAssets' => 'Boolean'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'ShowInMenus' => 0,
        'ShowInSearch' => 0,
        'SharingDisabled' => 1,
        'ResultsPerPage' => 10,
        'ShowAbsoluteURL' => 1,
        'ShowSummary' => 1,
        'SearchAssets' => 0
    ];
    
    /**
     * Defines the default heading level to use.
     *
     * @var array
     * @config
     */
    private static $heading_level_default = 'h4';
    
    /**
     * Answers the search results page for the site.
     *
     * @return SearchResultsPage
     */
    public static function find()
    {
        return self::get()->first();
    }
    
    /**
     * Answers a list of field objects for the CMS interface.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        // Obtain Field Objects (from parent):
        
        $fields = parent::getCMSFields();
        
        // Remove Field Objects:
        
        $fields->removeFieldsFromTab('Root.Main', ['Content', 'Metadata']);
        
        // Create Options Tab:
        
        $fields->findOrMakeTab('Root.Options', $this->fieldLabel('Options'));
        
        // Create Options Fields:
        
        $fields->addFieldsToTab(
            'Root.Options',
            [
                FieldSection::create(
                    'SearchResultsOptions',
                    $this->fieldLabel('SearchResults'),
                    [
                        TextField::create(
                            'ResultsPerPage',
                            $this->fieldLabel('ResultsPerPage')
                        ),
                        TextField::create(
                            'NoResultsMessage',
                            $this->fieldLabel('NoResultsMessage')
                        ),
                        TextField::create(
                            'ResultsMessage',
                            $this->fieldLabel('ResultsMessage')
                        ),
                        TextField::create(
                            'PagesMessage',
                            $this->fieldLabel('PagesMessage')
                        ),
                        CheckboxField::create(
                            'ShowAbsoluteURL',
                            $this->fieldLabel('ShowAbsoluteURL')
                        ),
                        CheckboxField::create(
                            'ShowSummary',
                            $this->fieldLabel('ShowSummary')
                        ),
                        CheckboxField::create(
                            'SearchAssets',
                            $this->fieldLabel('SearchAssets')
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
        
        $labels['Options'] = _t(__CLASS__ . '.OPTIONS', 'Options');
        $labels['SearchResults'] = _t(__CLASS__ . '.SEARCHRESULTS', 'Search Results');
        $labels['ResultsPerPage'] = _t(__CLASS__ . '.RESULTSPERPAGE', 'Results per page');
        $labels['NoResultsMessage'] = _t(__CLASS__ . '.NORESULTSMESSAGE', 'No results message');
        $labels['ResultsMessage'] = _t(__CLASS__ . '.RESULTSMESSAGE', 'Results message');
        $labels['PagesMessage'] = _t(__CLASS__ . '.PAGESMESSAGE', 'Pages message');
        $labels['SearchAssets'] = _t(__CLASS__ . '.SEARCHASSETS', 'Search assets');
        $labels['ShowSummary'] = _t(__CLASS__ . '.SHOWSUMMARY', 'Show summary');
        $labels['ShowAbsoluteURL'] = _t(__CLASS__ . '.SHOWABSOLUTEURL', 'Show absolute URL');
        
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
        
        $this->NoResultsMessage = _t(
            __CLASS__ . '.NORESULTSMESSAGEDEFAULT',
            'Sorry, your search did not return any results.'
        );
        
        $this->ResultsMessage = _t(
            __CLASS__ . '.RESULTSMESSAGEDEFAULT',
            'Your search for "{query}" found {total} matching {noun}.'
        );
        
        $this->PagesMessage = _t(
            __CLASS__ . '.PAGESMESSAGEDEFAULT',
            'Showing page {current} of {total} {noun}.'
        );
    }
    
    /**
     * Creates any required default records (if they do not already exist).
     *
     * @return void
     */
    public function requireDefaultRecords()
    {
        // Require Default Records (from parent):
        
        parent::requireDefaultRecords();
        
        // Require Default Records:
        
        if (!self::find()) {
            
            if (SiteTree::config()->create_default_pages && !self::find()) {
                
                // Create Page Record:
                
                $page = self::create([
                    'Title' => _t(__CLASS__ . '.DEFAULTTITLE', 'Search Results')
                ]);
                
                // Save and Publish Page Record:
                
                $page->write();
                $page->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE);
                $page->flushCache();
                
                // Report Database Alteration:
                
                DB::alteration_message('Created search results page', 'created');
                
            }
            
        }
    }
    
    /**
     * Answers the heading tag for the receiver.
     *
     * @return string
     */
    public function getHeadingTag()
    {
        if ($tag = $this->getField('HeadingLevel')) {
            return $tag;
        }
        
        return $this->config()->heading_level_default;
    }
}
