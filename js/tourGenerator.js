// Toptour-> topbartour

// Standard top bar tour
function topBarTour(){
	var tour = new Tour({
		name: 'top'
	});
	tour.addSteps([{element:"#topper",title:"Return to Dashboard", backdrop:true, placement:"bottom",animation: true,content:"Click the colored bar at the top of your screen to return back to your dashboard."}]),tour.init(),tour.start();
}

function activityDisplayTour(){
	// Bootstrap tour
	if (!($(window).width() < 700)) {
	  var tour = new Tour({
	    name: 'activitydisplay'
	  });
	  tour.addSteps([{element: "#deleteTriggerButton",title: "Delete Exercise",placement: "bottom", content: "Click here to delete this exercise. Remember, this will delete this exercise from ALL workout plans."}, {element: "#editTriggerButton",title: "Edit Exercise",content: "Click here to edit or update this exercise. Your current account will be listed as the new author of this exercise. All workout plans will be affected."}]),tour.init(),tour.start();
	}
}

function assignedTour(){
	// Create a new tour
	if ($(window).width() < 700) {
	} else {
		var tour = new Tour({
			name: 'assigned',
			onEnd: function (tour) {topBarTour();}
		});
		// Add your steps
		tour.addSteps([{
			element: "#editButtons",
			title: "Edit My Plans",
			backdrop: true,
			backdropPadding: 5,
			placement: "left",
			content: "Choose which workout plans you want in your feed. Click on the this button to turn on/off editing mode, in which you can remove workout plans from your feed simply by clicking on them. Don't worry, you can always find it in the search and add it back or have your trainer assign you the workout plan again. "
		}]) ;
		// Initialize method on the Tour class. Get's everything loaded up and ready to go.
		tour.init();
		// This starts the tour itself
		setTimeout(function() {
			tour.start();
		}, 500)
	}
}

function createActivityTour(){
	// Tour
	if ($(window).width() < 700) {
	} else {
	  var tour = new Tour({
	    name: 'createActivity',
	    onEnd: function (tour) {topTour();}
	  });
	  tour.addSteps([{ element: "#primaryForm", title: "Activity Form", placement:"right", backdrop: true, backdropPadding: 20, content: "Fill out the form here to create a new activity."}, { element: "#muscleForm", title: "Assign to Muscles", placement: "right", backdrop: true, backdropPadding: 20, content: "Click on the diagram to select muscles that your activity trains."}, { element: "#editForm", title: "Edit existing activity", placement: "bottom", backdrop: true, backdropPadding: 20, content: "Type in the name/id of an existing activity to edit it."}]),tour.init(),tour.start();
	}

}

function createSetTour(){
	// Set creation form tour
	var tour = new Tour({
	  name: 'createSet',
	  autoscroll: false,

	  onEnd: function(tour) {
	    topTour.init(), topTour.start();
	  }
	});
	tour.addSteps([{
	  element: "#chooseExercise",
	  title: "Choose your exercises",
	  placement: "bottom",
	  backdrop: true,
	  content: "Search and select the exercises that you will be including in your new workout plan."
	}, {
	  element: "#selectedExercise",
	  title: "Your selected exercises",
	  placement: "bottom",
	  backdrop: true,
	  content: "You can track the exercises you have added here. Click to remove them. "
	}, {
	  element: "#buildSet",
	  title: "Build your plan",
	  placement: "bottom",
	  backdrop: true,
	  content: "Choose an exercise and set the number of repetitions and weight (optional). You can also add in rest periods here."
	}, {
	  element: "#currentSet",
	  title: "Current Plan",
	  placement: "bottom",
	  backdrop: true,
	  content: "This is your current plan, after you have added to this, you can click, hold, and drag to rearrange the entries. You can also delete entries by clicking on the x next to their names. Click on \"set as default\" to confirm your changes."
	}, {
	  element: "#defaultDay",
	  title: "Default Day",
	  placement: "bottom",
	  backdrop: true,
	  content: "This is where you add in days. Here you can add days to your plan along with adding blank \"rest\" days."
	}, {
	  element: "#listOfDaysDiv",
	  title: "Days",
	  placement: "bottom",
	  backdrop: true,
	  content: "All the days you have added are listed here. You can delete entire days or edit the number of repetitions or weight of an exercise."
	}, {
	  element: "#assignUsers",
	  title: "Share with Friends",
	  placement: "bottom",
	  backdrop: true,
	  content: "Here you can share this workout with your friends. Simply search up their username, and click to select them."
	}, {
	  element: "#finalSet",
	  title: "Last Step",
	  placement: "bottom",
	  backdrop: true,
	  content: "Last but not least, title your plan, look everything over, then hit submit!"
	}]), tour.init(), tour.start();

	// Top tour to follow set creation form tour
	var topTour = new Tour({
	  name: 'top'
	});
	tour.addSteps([{
	  element: "#topper",
	  title: "Return to Trainer Dashboard",
	  backdrop: true,
	  placement: "bottom",
	  animation: true,
	  content: "Click the colored bar at the top of your screen to return back to your dashboard."
	}]); 
}


function exerciseTour(){

	// Exercise tour
	var tour = new Tour({
	  name: 'exerciseinitial'
	  });
	tour.addSteps([{element: "#menu-toggle",title: "Side Menu",placement: "right", content: "Click here to show/hide the side menu, here you can edit, assign or delete the exercise."},{element: "#accordion",title: "Exercise Preview",placement: "top", content: "Here you have a list of all the exercises included in this workout plan. To get details and extra information on an exercise, simply tap on it."}]),tour.init(),tour.start();

}

// Secondary tour for exercise
function startExerciseTourTwo(obj){
    var tour = new Tour({
      name: 'exerciseside',

      storage: window.localStorage
  });
  if ($(window).width() < 700) {
      tour.addSteps([{element: ("#" + title),title: "Title",placement: "top", content: "The name of the exercise to be completed is listed here."}, {element: ("#" + rep),title: "Repetitions and Weight",placement:"top",content: "This circle contains the number of repetitions to be completed, and sometimes weight (in kilograms). All of this information is available in preview."}, {element: ("#" + desc),title: "Description",placement: "top", content: "In this section, the details about this exercise are listed, including ID, author, full name, description, reps and weight. If you see a video icon, that means there is a video demonstration available - click to open it."},{element: ("#" + steps),title: "The Steps",placement: "top", content: "Listed here are the steps to complete the exercise. Follow them, stay safe, and enjoy your workout."}]),tour.init(),tour.start();
  }else {
      tour.addSteps([{element: ("#" + title),title: "Title", placement: "top", content: "The name of the exercise to be completed is listed here."}, {element: ("#" + rep),title: "Repetitions and Weight",placement:"left",content: "This circle contains the number of repetitions to be completed, and sometimes weight (in kilograms). All of this information is available in preview."}, {element: ("#" + desc),title: "Description", placement: "top", content: "In this section, the details about this exercise are listed, including ID, author, full name, description, reps and weight. If you see a video icon, that means there is a video demonstration available - click to open it."},{element: ("#" + steps),title: "The Steps",placement: "top", content: "Listed here are the steps to complete the exercise. Follow them, stay safe, and enjoy your workout."}]),tour.init(),tour.start();
  }
}

function clientHomeTour(){
    // Bootstrap tour
  var tour=new Tour({name:"home"});

  if ($(window).width() < 700) {
      tour.addSteps([{element:"#titleRight",title:"Search",placement:"top",content:"Click on this side of the screen to search through our database of public plans. From there, you can add plans to your personal list."},{element:"#titleLeft",title:"See My Sets",placement:"top",content:"Click on this side of the screen to open a list of your workout plans. Both you and your trainer can assign you workout plans."},{element:"#trainerbutt",title:"Settings",placement:"top",content:"Click here to access your settings page, where you can set your health metrics and add trainers."},{element:"#logoutbutt",title:"Go Home",placement:"top",content:"Click here to return to main menu."}]),tour.init(),tour.start();

  } else {
      tour.addSteps([{element:"#titleRight",title:"Search",placement:"right",content:"Click on this side of the screen to search through our database of public plans. From there, you can add plans to your personal list."},{element:"#titleLeft",title:"See My Plans",placement:"left",content:"Click on this side of the screen to open a list of your workout plans. Both you and your trainer can assign you workout plans."},{element:"#trainerbutt",title:"Settings",placement:"top",content:"Click here to access your settings page, where you can set your health metrics and add trainers."},{element:"#logoutbutt",title:"Go Home",placement:"top",content:"Click here to return to main menu."}]),tour.init(),tour.start();
  }
}

function clientSearchTour(){
	 if ($(window).width() < 700) {
    var tour = new Tour({
      name: 'search',
      onEnd: function (tour) {topTour();},
      autoscroll: false
    });
    tour.addSteps([{element:"#txt1",title:"Search our database",backdrop: true,backdropPadding: 15,placement:"bottom",animation: true,content:"Type in either the ID, name, or author of the plan. A list of matching plans should be instantly generated below, simply click to open them!"},{element:"#musclesMapImg",title:"Suggested Plans",animation: true,backdrop: true,backdropPadding: 5,placement:"bottom",content:"Click on the muscles that you want to focus on, and we will provide suggestions for workout plans that fit your needs."}]),tour.init(),tour.start();
  } else {

    var tour = new Tour({
      name: 'search',

      onEnd: function (tour) {topTour();}
    });
    tour.addSteps([{element:"#txt1",title:"Search our database",backdrop: true,backdropPadding: 15,placement:"bottom",animation: true,content:"Type in either the ID, name, or author of the plan. A list of matching plans should be instantly generated below, simply click to open them!"},{element:"#musclesMapImg",title:"Suggested Plans",animation: true,backdrop: true,backdropPadding: 5,placement:"left",content:"Click on the muscles that you want to focus on, and we will provide suggestions for workout plans that fit your needs."}]),tour.init(),tour.start();
  }
  function topTour(){
    var tour = new Tour({
      name: 'top'
    });
    tour.addSteps([{element:"#topper",title:"Return to Dashboard", backdrop:true, placement:"bottom",animation: true,content:"Click the colored bar at the top of your screen to return back to your dashboard."}]),tour.init(),tour.start();
  }
}

function trainerHomeTour(){
	// Tour page
	if ($(window).width() < 700) {
	    var tour = new Tour({
	      name: 'trainer'
	    });
	    tour.addSteps([{element:"#titleRight",title:"Create a plan",placement:"top",content:"Click on this side of the screen to access the workout plan creator."},{element:"#titleLeft",title:"Create an exercise",placement:"top",content:"Click on this side of the screen to access the exercise creator. "},{element:"#searchTour",title:"Access your creations",placement:"top",content:"This button brings you to a page where you can access your plans and exercises, along with other existing creations."},{element:"#logoutTour",title:"Go Home",placement:"top",content:"Click here to return to main menu."}]),tour.init(),tour.start();
	} else {
	    var tour = new Tour({
	      name: 'trainer'
	    });
	    tour.addSteps([{element:"#titleRight",title:"Create a plan",placement:"right",content:"Click on this side of the screen to access the workout plan creator."},{element:"#titleLeft",title:"Create an exercise",placement:"left",content:"Click on this side of the screen to access the exercise creator. "},{element:"#searchTour",title:"Access your creations",placement:"top",content:"This button brings you to a page where you can access your plans and exercises, along with other existing creations."},{element:"#logoutTour",title:"Go Home",placement:"top",content:"Click here to return to main menu."}]),tour.init(),tour.start();
	}
}


function workoutPreviewTour(){
	// Bootstrap tour
	if (!($(window).width() < 700)) {
	  var tour = new Tour({
	    name: 'workoutPreview'
	  });
	  tour.addSteps([{
	    element: "#assignerTriggerButton",
	    title: "Share with Friends",
	    placement: "right",
	    content: "Simply enter in the username of a friend, and click to share this workout plan with them."
	  }]), tour.init(), tour.start();
	}
}