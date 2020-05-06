// Called when the user clicks on the browser action.
chrome.browserAction.onClicked.addListener(function(tab) {
  // Send a message to the active tab
  chrome.tabs.query({ active: true, currentWindow: true }, function(tabs) {
    var tab = tabs[0];
    var url = new URL(tab.url)
    var domain = url.hostname
    chrome.tabs.sendMessage(tab.id, {"message": "custom_browser_action", "domain": domain});
  });
});

chrome.runtime.onMessage.addListener(
  function(request, sender, sendResponse) {
    // Open an incognito window with the URL provided.
    if( request.message === "open_new_tab" ) {
      chrome.windows.create({
        "url" : request.url,
        "incognito": true,
      });
    }
  }
);
