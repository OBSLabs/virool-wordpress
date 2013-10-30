jQuery(document).ready(function () {
  jQuery("input[name='virool_integration']").click(function() {
    var integration = jQuery(this).val();

    if (integration == '') {
      jQuery('.virool-widget-settings').hide();
    } else {
      jQuery('.virool-widget-settings.base-settings').show();

      switch (integration) {
        case 'overlay':
          jQuery('.virool-widget-settings.overlay-settings').show();
          jQuery('.virool-widget-settings.auto-widget-settings').hide();
          break;
        case 'autowidget_in_post':
          jQuery('.virool-widget-settings.overlay-settings').hide();
          jQuery('.virool-widget-settings.auto-widget-settings').show();
          break;
      }
    }
  });
});