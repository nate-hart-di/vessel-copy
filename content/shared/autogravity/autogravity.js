jQuery(document).ready(function ($) {
  (function (doc, id) {
    var js;

    if (doc.getElementById(id)) return;

    js = doc.createElement('script');
    js.id = id;
    js.src = 'https://apply.fjdrive.com/agwhitelabelwidget.js';
    doc.body.appendChild(js);
  })(document, 'autogravity-application-widget');

  if ($(window).width() < 768) {
    if (isMobile.iOS()) $('.fj-drive .android').hide();
    else $('.fj-drive .iOS').hide();
  }
});
