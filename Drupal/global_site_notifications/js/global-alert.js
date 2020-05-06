(function ($, Drupal) {
  var palette = {
    "popup": {
      "background": "#edeff5",
      "text": "#333333"
    },
    "button": {
      "background": "#013f71",
    }
  };
  if (drupalSettings.global_site_notifications.red_alert) {
    palette = {
      "popup": {
        "background": "#aa0000",
        "text": "#ffdddd"
      },
      "button": {
        "background": "#ff0000",
      }
    };
  }
  var init = {
    "palette": palette,
    "showLink": false,
    "theme": "classic",
    "position": drupalSettings.global_site_notifications.alert_position,
    "content": {
      "message": drupalSettings.global_site_notifications.alert_text,
      "dismiss": drupalSettings.global_site_notifications.alert_dismiss_text
    }
  };
  if (drupalSettings.global_site_notifications.alert_position === 'top_pushdown') {
    init.position = 'top';
    init.static = true;
  }
  if (drupalSettings.global_site_notifications.alert_disable_confirm_button) {
    init.elements = {};
    init.elements.dismiss = '';
  }
  window.cookieconsent.initialise(init);

})(jQuery, Drupal);
