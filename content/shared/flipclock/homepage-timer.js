jQuery(document).ready(function($){

  var now = new Date();
  var endDate = new Date(vesselTimerAssets.vesselEndDate)

  var diff = (endDate.getTime()/1000) - (now.getTime()/1000);

  var clock = new FlipClock($('.clock'),diff,{
    clockFace: 'DailyCounter',
    countdown: true
  })

});