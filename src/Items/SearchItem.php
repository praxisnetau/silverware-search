<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Search\Items
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-search
 */

namespace SilverWare\Search\Items;

use SilverStripe\Forms\CheckboxField;
use SilverWare\FontIcons\Extensions\FontIconExtension;
use SilverWare\Forms\FieldSection;
use SilverWare\Navigation\Model\BarItem;

/**
 * An extension of the bar item class for a search item.
 *
 * @package SilverWare\Search\Items
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-search
 */
class SearchItem extends BarItem
{
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'Search Item';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'Search Items';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'A bar item to show a search form for the site';
    
    /**
     * Defines an ancestor class to hide from the admin interface.
     *
     * @var string
     * @config
     */
    private static $hide_ancestor = BarItem::class;
    
    /**
     * Maps field names to field types for this object.
     *
     * @var array
     * @config
     */
    private static $db = [
        'ShowTitle' => 'Boolean'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'FontIcon' => 'search',
        'ShowTitle' => 0
    ];
    
    /**
     * Maps field and method names to the class names of casting objects.
     *
     * @var array
     * @config
     */
    private static $casting = [
        'LinkAttributesHTML' => 'HTMLFragment'
    ];
    
    /**
     * Defines the extension classes to apply to this object.
     *
     * @var array
     * @config
     */
    private static $extensions = [
        FontIconExtension::class
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
                    'TitleOptions',
                    $this->fieldLabel('TitleOptions'),
                    [
                        CheckboxField::create(
                            'ShowTitle',
                            $this->fieldLabel('ShowTitle')
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
        
        $labels['ShowTitle'] = _t(__CLASS__ . '.SHOWTITLE', 'Show title');
        $labels['TitleOptions'] = _t(__CLASS__ . '.TITLE', 'Title');
        
        // Answer Field Labels:
        
        return $labels;
    }
    
    /**
     * Answers an array of class names for the HTML template.
     *
     * @return array
     */
    public function getClassNames()
    {
        // Obtain Class Names:
        
        $classes = $this->styles('navbar.search');
        
        // Answer Class Names:
        
        return array_merge(
            parent::getClassNames(),
            $classes
        );
    }
    
    /**
     * Answers an array of attributes for the link element.
     *
     * @return array
     */
    public function getLinkAttributes()
    {
        $attributes = [
            'href' => '#',
            'class' => $this->style('navbar.search-icon'),
            'data-toggle' => 'popover',
            'data-container' => 'body',
            'data-placement' => 'bottom'
        ];
        
        if ($this->ShowTitle) {
            $attributes['title'] = $this->Title;
        }
        
        $this->extend('updateLinkAttributes', $attributes);
        
        return $attributes;
    }
    
    /**
     * Answers a string of attributes for the link element.
     *
     * @return string
     */
    public function getLinkAttributesHTML()
    {
        return $this->getAttributesHTML($this->getLinkAttributes());
    }
    
    /**
     * Renders the object for the HTML template.
     *
     * @param string $layout Page layout passed from template.
     * @param string $title Page title passed from template.
     *
     * @return DBHTMLText|string
     */
    public function renderSelf($layout = null, $title = null)
    {
        return $this->getController()->renderWith(static::class);
    }
}
