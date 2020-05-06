chrome.runtime.onMessage.addListener(
  function(request, sender, sendResponse) {
    if( request.message === "custom_browser_action" ) {
      // Get a hidden form field element.
      var $formElement = $('#hidden-form-field');
      // Use the hidden form field element to construct a URL on the same domain
      // and pass the value of the hidden form field as the query parameter.
      var recallUrl = 'https://' + request.domain + '/path?param=' + $formElement.val();
    }
  }
);
