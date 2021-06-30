(function($, window, Drupal, drupalSettings) {
  Drupal.behaviors.timezone_management = {
    attach: function(context, settings) {
      $('.js-update-current-time', context).once('timezone_management').each(function () {
      	var formatted_date = moment().tz(drupalSettings.admin_timezone_data.time_zone).format('Do MMMM YYYY - h:mm a');
      	$('.js-update-current-time').html(formatted_date);
      });
    }
  }
} (jQuery, this, Drupal, drupalSettings));