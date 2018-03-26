<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Search\Components
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-search
 */

namespace SilverWare\Search\Components;

use SilverStripe\CMS\Search\SearchForm;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverWare\Components\BaseComponentController;
use SilverWare\Search\Pages\SearchResultsPage;

/**
 * An extension of the base component controller class for a search component controller.
 *
 * @package SilverWare\Search\Components
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-search
 */
class SearchComponentController extends BaseComponentController
{
    /**
     * Answers a search form for the template.
     *
     * @return SearchForm
     */
    public function Form()
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
        
        $form = SearchForm::create($this, 'Form', $fields, $actions);
        
        // Update Form Action:
        
        if ($page = SearchResultsPage::find()) {
            $form->setFormAction($page->Link('SearchForm'));
        }
        
        // Answer Form Object:
        
        return $form;
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
