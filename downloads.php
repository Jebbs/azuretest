<div id="Downloads" class="tabcontent">
  <h3>Downloads</h3>
  <div id="downloadList">
    <table id="downloadTable"></table>
  </div>
</div>
<script>

//setInterval(updateDownloads, 3000);

function updateDownloads() {
  blobService.listBlobsSegmented('recordings', null, (error, results) => {
        if (error) {
            // Handle list blobs error
        } else {
            var list = [];

            console.log(results);
            console.log(results.entries);
            results.entries.forEach(blob => {
                console.log(blob);
                list.push(blob.name);
            });
            listDownloads(list);
        }
    });
}

function listDownloads(list){
  var dlist = document.getElementById("downloadList");

  var tbl  = document.getElementById("downloadTable");
  tbl.innerHTML = "<col width='200px'><col width='600px'>";

  list = list.reverse();

  var currentDate ="";

  var tr;
  var td;

  var i;
  for(i = 0; i < list.length; i++) {

    var date =  list[i].split("/")[0];
    if(date !== currentDate)
    {
      //mark as current date
      currentDate = date;

      //create row
      var tr = tbl.insertRow();
      tr.id = date;

      //create date cell
      var td = tr.insertCell();
      td.innerHTML = date.replace("_", "/").replace("_", "/");

      //create recordings cell
      td = tr.insertCell();
      td.innerHTML = "";
    }

    var time = list[i].split("/")[1].replace("_", ":").replace("_", ":");


    //console.log(list[i]);
    td.innerHTML += "<a style=\"display:block\" href=\"https://cuartest.blob.core.windows.net/recordings/"+list[i]+"\">"+time+"</a>"
  }

  var header = tbl.createTHead();
  var headerRow = header.insertRow();
  var th = headerRow.insertCell();
  th.innerHTML = "Day";
  th = headerRow.insertCell();
  th.innerHTML = "Recordings";
}

function getDownloadList(evt) {

  var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById("Downloads").style.display = "block";
    evt.currentTarget.className += " active";

    updateDownloads();
}
</script>
