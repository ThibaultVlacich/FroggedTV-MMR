(function($) {
  /**
   * Retrieve a parameter from the URL
   *
   * @param sParam  The name of the parameter to retrieve
   */
  $.urlParam = function(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
  };

  // ID of the Yasp profile to retrieve the MMR from
  var yaspProfileID     = parseInt($.urlParam('yID'));
  // URL of the script getting the MMR
  var urlForFetchingMMR = 'mmr.php?yID='+yaspProfileID;

  /**
   * Update the MMR displayed on the page
   */
  var updateMMR = function() {
    $.getJSON(urlForFetchingMMR)
     .done(function(data) {
       $('div#mmr span').text(data.mmr);
     })
     .fail(function() {
       $('div#mmr span').text('Erreur');
     });

    console.log("MMR mis à jour");
  };

  // Update the current MMR
  updateMMR();

  // Do it every minute
  setTimeout(function() {
    updateMMR();
  }, 60*1000);
}(jQuery));
