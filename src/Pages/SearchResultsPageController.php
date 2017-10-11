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
use SilverStripe\CMS\Search\SearchForm;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\PaginatedList;
use PageController;

/**
 * An extension of the page controller class for a search results page controller.
 *
 * @package SilverWare\Search\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-search
 */
class SearchResultsPageController extends PageController
{
    /**
     * Defines the allowed actions for this controller.
     *
     * @var array
     * @config
     */
    private static $allowed_actions = [
        'results'
    ];
    
    /**
     * Performs a search for the submitted keywords and renders the results.
     *
     * @param array $data
     * @param SearchForm $form
     * @param HTTPRequest $request
     *
     * @return array
     */
    public function results($data, SearchForm $form, HTTPRequest $request)
    {
        // Define Result:
        
        $result = ['Message' => $this->NoResultsMessage];
        
        // Obtain Search Query:
        
        if ($query = $form->getSearchQuery()) {
            
            // Disable Asset Searching (if required):
            
            if (!$this->SearchAssets) {
                $form->classesToSearch([SiteTree::class]);
            }
            
            // Define Results Per Page:
            
            if ($this->ResultsPerPage) {
                $form->setPageLength($this->ResultsPerPage);
            }
            
            // Obtain Search Results:
            
            $results = $form->getResults();
            
            // Did We Find Any Results?
            
            if ($results->getTotalItems() > 0) {
                
                // Define Results Message:
                
                $message = [$this->getResultsMessage($results, $query)];
                
                // Define Pages Message (if required):
                
                if ($results->TotalPages() > 1) {
                    $message[] = $this->getPagesMessage($results);
                }
                
                // Update Result:
                
                $result['Message'] = implode(' ', $message);
                $result['SearchResults'] = $results;
                
            }
            
        }
        
        // Answer Result:
        
        return $result;
    }
    
    /**
     * Answers the results message with tokens replaced.
     *
     * @param PaginatedList $results
     * @param string $query
     *
     * @return string
     */
    public function getResultsMessage(PaginatedList $results, $query)
    {
        return $this->replaceTokens(
            $this->data()->ResultsMessage,
            [
                'query' => $query,
                'total' => $results->getTotalItems(),
                'noun'  => $this->getResultNoun($results)
            ]
        );
    }
    
    /**
     * Answers the appropriate result noun for the given results list.
     *
     * @param PaginatedList $results
     *
     * @return string
     */
    public function getResultNoun(PaginatedList $results)
    {
        if ($results->getTotalItems() == 1) {
            return _t(__CLASS__ . '.RESULT', 'result');
        }
        
        return _t(__CLASS__ . '.RESULTS', 'results');
    }
    
    /**
     * Answers the pages message with tokens replaced.
     *
     * @param PaginatedList $results
     *
     * @return string
     */
    public function getPagesMessage(PaginatedList $results)
    {
        return $this->replaceTokens(
            $this->data()->PagesMessage,
            [
                'current' => $results->CurrentPage(),
                'total'   => $results->TotalPages(),
                'noun'    => $this->getPageNoun($results)
            ]
        );
    }
    
    /**
     * Answers the appropriate page noun for the given results list.
     *
     * @param PaginatedList $results
     *
     * @return string
     */
    public function getPageNoun(PaginatedList $results)
    {
        if ($results->TotalPages() == 1) {
            return _t(__CLASS__ . '.PAGE', 'page');
        }
        
        return _t(__CLASS__ . '.PAGES', 'pages');
    }
    
    /**
     * Replaces tokens found within the given text with their mapped value.
     *
     * @param string $text Text with tokens to replace.
     * @param array $tokens Array of tokens mapped to values.
     *
     * @return string
     */
    protected function replaceTokens($text, $tokens = [])
    {
        foreach ($tokens as $name => $value) {
            $text = str_ireplace("{{$name}}", $value, $text);
        }
        
        return $text;
    }
}
