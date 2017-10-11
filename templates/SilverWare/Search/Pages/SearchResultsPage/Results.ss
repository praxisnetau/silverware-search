<% if $SearchResults %>
  <div class="results">
    <% loop $SearchResults %>
      <article class="result">
        <header>
          <{$Up.HeadingTag}>
            <a href="$MetaLink" title="$MetaTitle">$MetaTitle</a>
          </{$Up.HeadingTag}>
        </header>
        <% if $Up.ShowAbsoluteURL %>
          <div class="link">$MetaAbsoluteLink</div>
        <% end_if %>
        <% if $HasMetaSummary && $Up.ShowSummary %>
          <div class="text">
            $MetaSummary
          </div>
        <% end_if %>
      </article>
    <% end_loop %>
  </div>
  <% include Pagination List=$SearchResults %>
<% end_if %>
