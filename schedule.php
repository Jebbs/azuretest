<div id="Schedule" class="tabcontent">
  <h3>Schedule</h3>
  <table id="scheduleTable"></table>
</div>


<script>

  var mondaySchedule=[];
  var tuesdaySchedule=[];
  var wednesdaySchedule=[];
  var thursdaySchedule=[];
  var fridaySchedule=[];
  var saturdaySchedule=[];
  var sundaySchedule=[];
  var Monday = "Monday";
  var Tuesday = "Tuesday";
  var Wednesday = "Wednesday";
  var Thursday = "Thursday";
  var Friday = "Friday";
  var Saturday = "Saturday";
  var Sunday = "Sunday";

  //initialize the schedule arrays
  function loadDay(schedule, time) {

    //if days are missing, don't try to load them
    if (typeof time !== 'undefined') {

      if(time === "")
        return;

        var times = time.split(",");

        var i;
        for(i = 0; i < times.length; i++) {
            schedule.push(times[i].trim().replace("[","").replace("]","").replace(" "," - "))
        }
      }
  }

  function updateScedule() {

    var tbl  = document.getElementById("scheduleTable");
    tbl.innerHTML = "<col width='200px'><col width='600px'>";

    setDay("Monday", mondaySchedule, tbl);
    setDay("Tuesday", tuesdaySchedule, tbl);
    setDay("Wednesday", wednesdaySchedule, tbl);
    setDay("Thursday", thursdaySchedule, tbl);
    setDay("Friday", fridaySchedule, tbl);
    setDay("Saturday", saturdaySchedule, tbl);
    setDay("Sunday", sundaySchedule, tbl);

    var header = tbl.createTHead();
    var headerRow = header.insertRow();
    var th = headerRow.insertCell();
    th.innerHTML = "Day";
    th = headerRow.insertCell();
    th.innerHTML = "Record Times";

  }

  function setDay(dayName, schedule, table) {
    var tr = table.insertRow();
    tr.id = dayName;
    var td = tr.insertCell();
    //td.innerHTML = "<input type='checkbox'>";
    //td = tr.insertCell();
    td.innerHTML = dayName;
    td = tr.insertCell();
    td.innerHTML = "";

    var i;
    for(i = 0; i < schedule.length; i++) {
      td.innerHTML += "<pre class=\"scheduleDisplay\"></pre>";
      td.children[i].innerHTML = schedule[i];
      td.children[i].innerHTML +="<span onclick=\"removeTimeslot("+dayName+","+i+")\" class=\"hidden\">&times</span>" + "\n";
    }

    td.innerHTML += "<div id=\""+dayName+"TimeAdd\" class=\"scheduleDisplay\"></div>";
    td.children[i].innerHTML ="<span>&nbsp</span>";
    td.children[i].innerHTML +="<span onclick=\"showTimeAdd("+dayName+")\" class=\"addTime\">+</span>" + "\n";
  }

  function showTimeAdd(dayName) {
    var inputContent = document.getElementById(dayName+"TimeAdd");

    inputContent.innerHTML = "<input type=\"time\" name=\"start\" id=\""+dayName+"Start\">";
    inputContent.innerHTML += " to ";
    inputContent.innerHTML += "<input type=\"time\" name=\"stop\" id=\""+dayName+"Stop\"> ";
    inputContent.innerHTML += "<button type=\"button\" onclick=\"addTimeslot("+dayName +")\">Add Time</button> ";
    inputContent.innerHTML += "<button type=\"button\" onclick=\"hideTimeAdd("+dayName +")\">Cancel</button>";
  }

  function hideTimeAdd(dayName) {
    var inputContent = document.getElementById(dayName+"TimeAdd");
    inputContent.innerHTML ="<span>&nbsp</span>";
    inputContent.innerHTML +="<span onclick=\"showTimeAdd("+dayName+")\" class=\"addTime\">+</span>" + "\n";
  }


  function getINISchedule(localSchedule) {
    var newSchedule = "";

    var i;
    for(i = 0; i < localSchedule.length; i++) {
      newSchedule += "["+localSchedule[i].replace(" - ", " ")+"]";
      if(i+1 < localSchedule.length)
        newSchedule += ",";
    }
    console.log(newSchedule);
    return newSchedule;
  }

  function addTimeslot(day)
  {
    var timeStart = document.getElementById(day+"Start").value;
    var timeStop = document.getElementById(day+"Stop").value;
    if(timeStart === "" && timeStop === "") {
      alert("Please enter a correct starting and ending time for a recording.");
      return;
    }
    else if(timeStart === "") {
      alert("Please enter a correct starting time for a recording.");
      return;
    }
    else if(timeStop === "") {
      alert("Please enter a correct ending time for a recording.");
      return;
    }

    switch(day) {
      case "Monday":
        mondaySchedule.push(timeStart + " - " + timeStop);
        mondaySchedule.sort();
        schedule_file.Schedule.monday = getINISchedule(mondaySchedule);
        break;
      case "Tuesday":
        tuesdaySchedule.push(timeStart + " - " + timeStop);
        tuesdaySchedule.sort();
        schedule_file.Schedule.tuesday = getINISchedule(tuesdaySchedule);
        break;
      case "Wednesday":
        wednesdaySchedule.push(timeStart + " - " + timeStop);
        wednesdaySchedule.sort();
        schedule_file.Schedule.wednesday = getINISchedule(wednesdaySchedule);
        break;
      case "Thursday":
        thursdaySchedule.push(timeStart + " - " + timeStop);
        thursdaySchedule.sort();
        schedule_file.Schedule.thursday = getINISchedule(thursdaySchedule);
        break;
      case "Friday":
        fridaySchedule.push(timeStart + " - " + timeStop);
        fridaySchedule.sort();
        schedule_file.Schedule.friday = getINISchedule(fridaySchedule);
        break;
      case "Saturday":
        saturdaySchedule.push(timeStart + " - " + timeStop);
        saturdaySchedule.sort();
        schedule_file.Schedule.saturday = getINISchedule(saturdaySchedule);
        break;
      case "Sunday":
        sundaySchedule.push(timeStart + " - " + timeStop);
        sundaySchedule.sort();
        schedule_file.Schedule.sunday = getINISchedule(sundaySchedule);
        break;
    }

    console.log(encode(schedule_file));

    blobService.createBlockBlobFromText('configuration', 'config.ini', encode(schedule_file), function(error, result, response) {
    if (!error) {
    // file uploaded
    }
    });

    updateScedule();
  }

  function removeTimeslot(day, slot) {
    var schedule;

    switch(day) {
      case "Monday":
        schedule = mondaySchedule;
        var toRemove = schedule[slot];
        schedule = schedule.filter(function(item) {return item !== toRemove});
        mondaySchedule = schedule;
        schedule_file.Schedule.monday = getINISchedule(mondaySchedule);
        break;
      case "Tuesday":
        schedule = tuesdaySchedule;
        var toRemove = schedule[slot];
        schedule = schedule.filter(function(item) {return item !== toRemove});
        tuesdaySchedule = schedule;
        schedule_file.Schedule.tuesday = getINISchedule(tuesdaySchedule);
        break;
      case "Wednesday":
        schedule = wednesdaySchedule;
        var toRemove = schedule[slot];
        schedule = schedule.filter(function(item) {return item !== toRemove});
        wednesdaySchedule = schedule;
        schedule_file.Schedule.wednesday = getINISchedule(wednesdaySchedule);
        break;
      case "Thursday":
        schedule = thursdaySchedule;
        var toRemove = schedule[slot];
        schedule = schedule.filter(function(item) {return item !== toRemove});
        thursdaySchedule = schedule;
        schedule_file.Schedule.thursday = getINISchedule(thursdaySchedule);
        break;
      case "Friday":
        schedule = fridaySchedule;
        var toRemove = schedule[slot];
        schedule = schedule.filter(function(item) {return item !== toRemove});
        fridaySchedule = schedule;
        schedule_file.Schedule.friday = getINISchedule(fridaySchedule);
        break;
      case "Saturday":
        schedule = saturdaySchedule;
        var toRemove = schedule[slot];
        schedule = schedule.filter(function(item) {return item !== toRemove});
        saturdaySchedule = schedule;
        schedule_file.Schedule.saturday = getINISchedule(saturdaySchedule);
        break;
      case "Sunday":
        schedule = sundaySchedule;
        var toRemove = schedule[slot];
        schedule = schedule.filter(function(item) {return item !== toRemove});
        sundaySchedule = schedule;
        schedule_file.Schedule.sunday = getINISchedule(sundaySchedule);
        break;
    }

    console.log(schedule);
    console.log(encode(schedule_file));

    blobService.createBlockBlobFromText('configuration', 'config.ini', encode(schedule_file), function(error, result, response) {
    if (!error) {
    // file uploaded
    }
    });

    updateScedule();
  }

  function loadSchedule(evt) {

    mondaySchedule=[];
    tuesdaySchedule=[];
    wednesdaySchedule=[];
    thursdaySchedule=[];
    fridaySchedule=[];
    saturdaySchedule=[];
    sundaySchedule=[];
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById('Schedule').style.display = "block";
    evt.currentTarget.className += " active";

    //contact the blob storage
    blobService.getBlobToText('configuration', 'config.ini', function(error, text, result, response) {
      if (!error) {
        schedule_file = decode(text);

        loadDay(mondaySchedule, schedule_file.Schedule.monday);
        loadDay(tuesdaySchedule, schedule_file.Schedule.tuesday);
        loadDay(wednesdaySchedule, schedule_file.Schedule.wednesday);
        loadDay(thursdaySchedule, schedule_file.Schedule.thursday);
        loadDay(fridaySchedule, schedule_file.Schedule.friday);
        loadDay(saturdaySchedule, schedule_file.Schedule.saturday);
        loadDay(sundaySchedule, schedule_file.Schedule.sunday);
        console.log(encode(schedule_file));

        updateScedule();
      }
    });
	}
</script>