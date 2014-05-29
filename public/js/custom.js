$(document).ready(function() {

  // icon click focus
  $('div.icon').click(function(){
    $('input#search').focus();
  });


  $('h3.highlight').click(function(){


  });

  //jquery submit function
  // $("input#search").live("keyup", function(e){
    $(document).on("keyup", "input#search", function(e){
    // set timeout
    clearTimeout($.data(this, 'timer'));

    // set search string
    var search_string = $(this).val();

    // do search
    if(search_string === ''){
      $("ul#results").fadeOut();
      $("h4#results").fadeOut();
    } else {
      $("ul#results").fadeIn();
      $("h4#results-text").fadeIn();
      $(this).data('timer', setTimeout(search, 100));
    }
  });

  // Live Search
  // on search submit and get results
  function search(){
    var query_value = $('input#search').val();
    $('strong#search-string').html(query_value);
    if(query_value !== ''){
      $.ajax({
        type: "POST",
        url: "search.php",
        data: { query: query_value},
        cache: false,
        success: function(html){
          $("ul#results").html(html);
        }
      });
    }
    return false;
  }

});
