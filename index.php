<html>
<link rel="stylesheet" type="text/css" href="styles.css">
<?php
	$maxcols = 5;
?>
 <head>
<title>CUAR</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="scripts/azure-storage.blob.js"></script>
  <script src="scripts/ini.js"></script>
  <script>
    var schedule_file;
    // Blob-related code goes here

	  const account = {
      name: 'cuartest',
      sas:  'se=2118-05-09T00%3A00%3A00Z&sp=rwdlac&sv=2017-07-29&ss=b&srt=sco&sig=CK/oHeN5SvFXYc49VyPba8bgIXqQFW2vAIz45NhYhwg%3D'
    };

    const blobUri = 'https://' + account.name + '.blob.core.windows.net';
    const blobService = AzureStorage.Blob.createBlobServiceWithSas(blobUri, account.sas);
  </script>
 </head>
 <body>
	<div class="header" align="center"><img src="logo.png" alt="logo" /></div>
	<div class="tab">
  <button class="tablinks" onclick="loadStatus(event)" id="defaultOpen">Status</button>
  <button class="tablinks" onclick="loadSchedule(event)">Schedule</button>
  <button class="tablinks" onclick="getDownloadList(event)">Downloads</button>
</div>

<?php include 'status.php';?>
<?php include 'schedule.php';?>
<?php include 'downloads.php';?>

<script>
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
</script>
 </body>
</html>