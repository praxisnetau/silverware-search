<div $AttributesHTML>
  <% if $IsIcon %>
    <a $LinkAttributesHTML>$FontIconTag</a>
    <div class="navbar-search-popover">
      $SearchFormPopover
    </div>
  <% else %>
    <div class="navbar-search-field">
      $SearchFormField
    </div>
  <% end_if %>
  <div class="navbar-search-mobile">
    $SearchFormMobile
  </div>
</div>
