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

use SilverStripe\CMS\Search\SearchForm;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverWare\Model\ComponentController;
use SilverWare\Search\Pages\SearchResultsPage;

/**
 * An extension of the component controller class for a search item controller.
 *
 * @package SilverWare\Search\Items
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-search
 */
class SearchItemController extends ComponentController
{
    /**
     * Answers a search form with the given name for the template.
     *
     * @param string $name
     *
     * @return SearchForm
     */
    public function getSearchForm($name)
    {
        // Create Form Fields:
        
        $fields = FieldList::create(
            TextField::create(
                'Search',
                '',
                $this->getSearchKeywords()
            )->setAttribute('placeholder', _t(__CLASS__ . '.SEARCH', 'Search'))
        );
        
        // Create Form Actions:
        
        $actions = FieldList::create(
            FormAction::create('results', _t(__CLASS__ . '.GO', 'Go'))
        );
        
        // Create Form Object:
        
        $form = SearchForm::create($this, $name, $fields, $actions);
        
        // Update Form Action:
        
        if ($page = SearchResultsPage::find()) {
            $form->setFormAction($page->Link('SearchForm'));
        }
        
        // Answer Form Object:
        
        return $form;
    }
    
    /**
     * Answers the field mode search form for the template.
     *
     * @return SearchForm
     */
    public function SearchFormField()
    {
        return $this->getSearchForm('SearchFormField');
    }
    
    /**
     * Answers the mobile search form for the template.
     *
     * @return SearchForm
     */
    public function SearchFormMobile()
    {
        return $this->getSearchForm('SearchFormMobile');
    }
    
    /**
     * Answers the popover search form for the template.
     *
     * @return SearchForm
     */
    public function SearchFormPopover()
    {
        return $this->getSearchForm('SearchFormPopover');
    }
    
    /**
     * Answers a string of keywords for the current search.
     *
     * @return string
     */
    public function getSearchKeywords()
    {
        return ($controller = $this->getCurrentController()) ? $controller->getRequest()->getVar('Search') : '';
    }
}
