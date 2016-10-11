/*
 * Necessary auto-calls
*/ 

// Get rid of load screen
$(".loadingScreen").animate({height:'0'});
// Display alert if successful 
if (window.location.hash == "#success"){
  document.getElementById("alert").style.display = "block";
}
$(window).scrollTop(0);

/*
 * Muscle handlers
*/ 
function initiateMuscleImageMap(){
  // Initiate location map generation
  $('map').imageMapResize();
  if($('#location-map')) {
    $('#location-map area').each(function() {
      var id = $(this).attr('id');
      $(this).mouseover(function() {
        $('#overlay'+id).show();
      });
      $(this).mouseout(function() {
        var id = $(this).attr('id');
        $('#overlay'+id).hide();
      });

    });
  }
}

// Update muscles
function addMuscleToUIList() {

  var muscleString = document.getElementById("muscleString").value;
  $("#muscleList").empty();

  muscles.selected.forEach(function(currentValue, index){
    var muscleName = currentValue;
    var muscleList = document.getElementById("muscleList");
    var newMuscleLI = document.createElement("li");
    var deleteButton = $("<button />").addClass("deleteButton btn btn-danger").text("x");
    $(deleteButton).attr("style", "text-align:left;  margin-right:10px; padding-left:3px; padding-top:0px; float:left; padding-bottom:2px; padding-right:3px; font-size:8px; margin-top:-3px;");
    $(deleteButton).attr("onclick", "removeThisMuscle(this)");
    deleteButton.appendTo(newMuscleLI);
    newMuscleLI.appendChild(document.createTextNode(capitalizeFirstLetter(filterOutUnderscores(muscleName))));
    newMuscleLI.setAttribute("data-name", muscleName);
    $(newMuscleLI).addClass("list-group-item"); 
    muscleList.appendChild(newMuscleLI);
  });
}


/*
 * Check marks
*/ 

// Draw green check
function greenMarkTrigger(cb){
  $('<div class="modal-backdrop" id = "affirmationCheckModal" style = "z-index: 1100; background-color: rgba(0, 0, 0, 0.9)"></div>').hide().appendTo(document.body).fadeIn(500);
  var heights = $(window).height(); 
  var widths = $(window).width(); 
  $('#successCanvas').css("width", "300");
  $('#successCanvas').css("z-index", "1101");
  $('#successCanvas').css("left", ((widths/2) - 150) + "px");
  $('#successCanvas').css("top", ((heights/2) - 150) + "px");
  var start = 100;
  var mid = 145;
  var end = 250;
  var width = 22;
  var leftX = start;
  var leftY = start;
  var rightX = mid + 2;
  var rightY = mid - 3;
  var animationSpeed = 10;
  var ctx = document.getElementById('successCanvas').getContext('2d');
  ctx.lineWidth = width;
  ctx.strokeStyle = 'rgba(2, 255, 1, 1)';
  for (i = start; i < mid; i++) {
    var drawLeft = window.setTimeout(function () {
      ctx.beginPath();
      ctx.moveTo(start, start);
      ctx.lineTo(leftX, leftY);
      ctx.lineCap = 'round';
      ctx.stroke();
      leftX++;
      leftY++;
    }, 1 + (i * animationSpeed) / 3);
  }
  for (i = mid; i < end; i++) {
    var drawRight = window.setTimeout(function () {
      ctx.beginPath();
      ctx.moveTo(leftX + 2, leftY - 3);
      ctx.lineTo(rightX, rightY);
      ctx.stroke();
      rightX++;
      rightY--;
    }, 1 + (i * animationSpeed) / 3);
  }
  cb();
}


/*
 * XML requests
 */ 

// Search handler
function suggestionsSearch(resultDiv, query, baseURL, cb){
  if (query.length == 0){
    resultDiv.innerHTML = "";
  } else {
    getRequest(baseURL + query, function(responseText){
      resultDiv.innerHTML = responseText;
      cb(responseText);
    });
  }
}

// Generic get request abstracted
function getRequest(getURL, cb){
  var getRequest=new XMLHttpRequest();
  getRequest.onreadystatechange=function() {
    if (getRequest.readyState==4 && getRequest.status==200) {
      cb(getRequest.responseText);
    }
  };
  getRequest.open("GET", getURL,true);
  getRequest.send();
}

// Generic POST request abstracted
function postRequest(getURL, JSONstring, cb){
  var postRequest=new XMLHttpRequest();
  var params = JSONstring;
  postRequest.onreadystatechange=function() {
    if (postRequest.readyState==4 && postRequest.status==200) {
      cb(postRequest.responseText);
    }
  }
  postRequest.open("POST", getURL,true);
  postRequest.setRequestHeader("Content-type", "application/json")
  postRequest.send(params);
}


/*
 * Home pages/indexes
*/ 

// Left right object hover color alternator. Left and right target id arguments are optional, leave null for none
function leftRightHoverController(leftObjectID, rightObjectID, leftOnColor, leftOffColor, rightOnColor, rightOffColor){
  // Color effects for the left object of the screen
  $(leftObjectID).hoverIntent(function(){
    $(leftObjectID).animate({
      backgroundColor: leftOnColor
    }, 341 );
  }, function(){
    $(leftObjectID).animate({
      backgroundColor: leftOffColor
    }, 341 );
  });
  // Color effects for the right object of the screen
  $(rightObjectID).hoverIntent(function(){
    $(rightObjectID).animate({
      backgroundColor: rightOnColor
    }, 341 );          
  }, function(){
    $(rightObjectID).animate({
      backgroundColor: rightOffColor
    }, 341 );
  });
}

// Generates triangle
// Assuming IDs for the primary triangles being #triangle-topright, #triangle-topLeft; and the titles being, #titleLeft, #titleRight
function triangleGen(){
  var t = $("#triangle-topright"),
      e = ($("#trainer"), void 0 !== document.width ? document.width : document.body.offsetWidth),
      o = void 0 !== document.height ? document.height : document.body.offsetHeight;
  t.css("border-right-width", " " + (7 * e / 20 | 0) + "px"), t.css("border-top-width", " " + (0 | o) + "px");
  var r = $("#triangle-topleft");
  r.css("border-left-width", " " + (7 * e / 20 | 0) + "px"), r.css("border-top-width", " " + (0 | o) + "px");
  var s = $("#triangle-up");
  s.css("border-right-width", " " + (7 * e / 20 | 0) + "px"), s.css("border-left-width", " " + (7 * e / 20 | 0) + "px"), s.css("border-bottom-width", " " + (0 | o) + "px");
  var i = $("#titleLeft"),
      a = $("#titleRight"),
      n = $(".glyphicon"),
      d = 7 * e / 20,
      c = Math.atan2(o, d) * (180 / Math.PI);
  if (a.css("-webkit-transform", " rotate(" + (360 - c | 0) + "deg)"), a.css("-moz-transform", " rotate(" + (360 - c | 0) + "deg)"), a.css("-o-transform", " rotate(" + (360 - c | 0) + "deg)"), i.css("-webkit-transform", " rotate(" + (0 + c | 0) + "deg)"), i.css("-moz-transform", " rotate(" + (0 + c | 0) + "deg)"), i.css("-o-transform", " rotate(" + (0 + c | 0) + "deg)"), e > o) {
      var h = e / 3,
          h = Math.round(100 * h) / 100;
      i.css("right", e / 100), a.css("left", e / 100)
  } else {
      var h = o / 3,
          h = Math.round(100 * h) / 80;
      i.css("right", -(e / 8)), a.css("left", -(e / 8))
  }
  i.css("font-size", h + "%"), a.css("font-size", h + "%"), n.css("font-size", h + "%");
  var m = document.getElementById("titleLeft").offsetWidth;
  a.css("width", m + "px");
  var g = $("#title"),
      f = e / 2,
      f = Math.round(100 * f) / 100;
  g.css("font-size", f + "%");
  var l = $("#plusLeft"),
      u = $("#plusRight"),
      w = Math.round(100 * e) / 100;
  l.css("font-size", w + "%"), u.css("font-size", w + "%")
}


/*
 * Loading screen
*/ 




/*
 * Navigation section
*/

// Leave loadingScreenColor request blank if necessary
function goToPage(loadingScreenColorRequest, htmlColorClass, urlRedirect) {
  // Manually set loading page properties
  var windowHeight = $(window).height();
  var windowWidth = $(window).width();
  $(".loadingScreen").height(windowHeight);
  if (!(loadingScreenColorRequest == null)){
    $('.loadingScreen').css('background-color', loadingScreenColorRequest + ' !important');
  }
  $('.loadingScreen').width(0);
  $('.loadingScreen').css('left', '0px !important');
  $(".loadingScreen").animate({
    width: windowWidth
  }), $(".loadingScreen").fadeIn("slow"), setTimeout(function(){
    document.getElementsByTagName('html')[0].className += (' ' + htmlColorClass);
    $(document.body).hide();
    window.location.href = urlRedirect;        
  }, 500);
}

// Go to app homepage
function goToAppHome() {
    goToPage("#ffae19", "lightOrangeLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/appIndex');
}

// Go to trainer search page
function goToTrainerSearchPage() {
    goToPage(null, "trainerLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/searchTrainer");
}

// Go to create activity page
function goToCreateActivityPage() {
    goToPage(null, "trainerLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/createActivity");
}

// Go to trainer clients apge
function goToTrainerClientPage() {
    goToPage(null, "trainerLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/trainerClients");
}

// Go to create set page
function goToCreateSetPage() {
    goToPage(null, "trainerLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/createSet");
}

// Go to client homepage
function goToClientHome() {
  goToPage("#ffa500", "clientLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/home');
}

// Go to logout page
function goToLogoutPage() {
  goToPage("#ffae19", "lightOrangeLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/logout');
}

// Go to login page
function goToLoginPage() {
  goToPage("#ffae19", "lightOrangeLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/login');
}

// Go to logout page
function goToRegisterPage() {
  goToPage("#ffae19", "lightOrangeLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/register');
}

// Go to company homepage
function goToCompHomepage() {
  goToPage("#ffae19", "lightOrangeLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/');
}

// Go to friends page
function goToFriendsPage() {
  goToPage("ffa500", "clientLoadingScreenColor", 'https://www.whimmly.com/TrainerAssist/friends');
}
  
// Go to trainer homepage
function goToTrainerHome() {
  goToPage("#0099CC", "trainerLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/trainer");
}
  
// Go to trainer homepage
function goToBuildSet() {
  goToPage("#0099CC", "trainerLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/createSet");
}
  
// Go to trainer homepage
function goToBuildActivity() {
  goToPage("#0099CC", "trainerLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/createActivity");
}

// Go to settings page
function goToSettings(){
  goToPage(null, "clientLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/settings");
}

// Go to assigned sets
function goToAssigned(){
  goToPage(null, "clientLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/assigned");
}

// Go to search
function goToSearch(){
  goToPage(null, "clientLoadingScreenColor", "https://www.whimmly.com/TrainerAssist/search");
}

/*
 * Miscellanious
*/ 

// Check whether integer is valid (used for validating form entries)
function isInt(t) {
  return !isNaN(t) && function(t) {
    return (0 | t) === t
  }(parseFloat(t))
}

// Same as isInt, but with alerts
function checkInp(obj, str)
{
  x = obj.value;
  if (isNaN(x)) 
  {
    obj.value = "";
    alert("Numbers only");
    return false;
  } 
}

// Check mark refresh
function refresh(){
  greenMarkTrigger(function(){
    setTimeout(function(){
      // Redirect page
      var windowHeight = $(window).height();
      var windowWidth = $(window).width();
      $(".loadingScreen").height(windowHeight);
      $('.loadingScreen').width(0);
      $('.loadingScreen').css('left', '0px !important');
      $(".loadingScreen").animate({
        width: windowWidth
      }), $(".loadingScreen").fadeIn("slow"), setTimeout(function(){
        document.getElementsByTagName('html')[0].className += (' clientLoadingScreenColor');
        $(document.body).hide();
        location.reload();      
      }, 500);
    }, 2000);
  });
}

// Capitalize first letter
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

// Capitalize first letter
function filterOutUnderscores(string) {
  return string.replace(/_/g, " ");
}

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
  results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


/*
 * Youtube video processor
 */ 
// Process youtube URL
function getYoutubeURL(url) {
  var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
  var match = url.match(regExp);
  if (match && match[2].length == 11) {
    return match[2];
  } else {
    return 'error';
  }
}
function youtubePlayerInitiate(){
  // Upon video show modal, play the youtube video
  $('#youtubeVideoPlayer').on('show.bs.modal', function (e) {
    var url = (e.relatedTarget).getAttribute("data-url");
    var embedCode = '<iframe width="560" height="315" src="//www.youtube.com/embed/' 
    + getYoutubeURL(url) + '" frameborder="0" allowfullscreen></iframe>';
    document.getElementById("videoContent").innerHTML = embedCode;
  });
}

/*
 * Sidebar setup
 */
var sidebarWidthAdjusted;
function sidebarInitiate(){

  sidebarWidthAdjusted = (($(document.getElementById("sidebar-wrapper")).width() + 70) + "px");

  // Setup sidebar inital call
  // Adjust the sidebar width if window is big enough
  if ($(window).width() > 767) {
    $(document.getElementById("sidebarToggleWrapper")).width(sidebarWidthAdjusted);
  }

  // Special toggle action for sidebar
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });  
}
  

// Sidebar toggle action
function toggleSidebar(obj){

  
  // Test whether sidebar currently out, if closed the width is 70px
  if ($(obj).parent().parent().width() == "70"){
    if ($(window).width() > 767) {
      // Trigger sidebar to shift over to left side
      $(obj).parent().parent().animate(
      {
        'width': sidebarWidthAdjusted
      },300);
    } else {
      // Open sidebar over top
      $(obj).parent().parent().animate(
      {
        'width': (325 + "px"),
      },300);
    }
  } else {
    // Shrink sidebar to hide
    $(obj).parent().parent().animate(
    {
      'width': '70px',
      'border-bottom-right-radius': '20px'
    },400, "linear");       
  }
}
