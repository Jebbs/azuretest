<div id="Status" class="tabcontent">
  <h3>Status</h3>
  <div>
    <div id="map"></div>
    <div id="curentStatus">
    </div>
  </div>
  <script>

  // The location of buoy
  var cuarPos = {lat: 47.758971667, lng: -122.190935};
  var temp = 24;

  //setInterval(statusLoad, 3000);

  function loadStatus(evt) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById("Status").style.display = "block";
    evt.currentTarget.className += " active";
    statusLoad();
	}

  function statusLoad() {

    blobService.listBlobsSegmented('recordings', null, (error, results) => {
        if (error) {
            // Handle list blobs error
        } else {
            var lastRecording = results.entries[results.entries.length-1].lastModified;

            console.log(lastRecording);

            blobService.getBlobToText('status', 'status.ini', function(error, text, result, response) {
            if (!error) {

              var st = decode(text);

              console.log(st);


              var day = (new Date()).getDay();
              var time = (new Date()).getTime();
              console.log(day);
              console.log(time);

              var stats;

              if(st.Status.IsRecording === "True") {
                stats = "CUAR is currently recording."
              }
              else if (st.Status.IsUploading === "True") {
                stats = "CUAR is currently uploading a recording."
              }
              else {
                stats = "CUAR is currently idle."
              }


              setStatusData(st.GPS.Latitude,st.GPS.Longitude,
                            st.Temperature.Celsius,lastRecording,0,
                            result.lastModified,stats);
            }
          });
        }
    });


  }


  function setStatusData(lt, ln, temp, lastRec, nextRec, lastStat, status) {




    var d = document.getElementById("curentStatus");

    d.innerHTML = "<p>Last Status Update: " + lastStat + "</p>";
    d.innerHTML += "<p>" + status + "</p>";
    d.innerHTML += "<p>Last recording: " + lastRec + "</p>";
    d.innerHTML += "<p>Ambient Temperature: " + parseFloat(temp).toFixed(1) + "°C</p>";
    /*d.innerHTML += "<p>Next recording: " + nextRec+ "</p>";*/


    if (lt !== "?" && ln !== "?" )
    {
      cuarPos = {lat: parseFloat(lt), lng: parseFloat(ln)};
      initMap();
    }


  }


  // Initialize and add the map
  function initMap() {
  // The map, centered on the buoy
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 16, center: cuarPos});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: cuarPos, map: map});
  }
  </script>

  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwGUv5cBvDJSmvevyJZT060yat-mEoWKw&callback=initMap">
  </script>
</div>