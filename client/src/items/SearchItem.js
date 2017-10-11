/* Search Item
===================================================================================================================== */

import $ from 'jquery';

$(function() {
  
  // Handle Search Items:
  
  $('.searchitem').each(function() {
    
    var $self = $(this);
    var $link = $self.find('a');
    
    $link.popover({
      html: true,
      content: $self.find('.navbar-search-popover')
    });
    
  });
  
  // Define Resize Handler:
  
  var hidePopovers = function() {
    
    $('.searchitem').each(function() {
      $(this).find('a').popover('hide');
    });
    
  };
  
  // Attach Resize Handler:
  
  $(window).resize(hidePopovers);
  
});
