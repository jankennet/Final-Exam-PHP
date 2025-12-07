<?php
$page='dashboard';
include 'includes/visitors.php';
$total_visitors = getVisitorCount();
$today_visitors = getTodayVisitors();
?>
<!doctype html>
<html lang="en">
  <?php
    include 'includes/head.php';
  ?>
  <body>
  <?php
    include 'includes/nav.php';
  ?> 

<div class="container-fluid">
  <div class="row">
   <?php
    include 'includes/sidebar.php';
  ?> 

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>        
      </div>

      <div class="row mb-4">
        <div class="col-md-6">
          <div class="card text-white bg-primary">
            <div class="card-body">
              <h5 class="card-title">Total Visitors</h5>
              <p class="card-text" style="font-size: 2rem;"><?=$total_visitors?></p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card text-white bg-success">
            <div class="card-body">
              <h5 class="card-title">Today's Visitors</h5>
              <p class="card-text" style="font-size: 2rem;"><?=$today_visitors?></p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Export Visitor Logs</h5>
            </div>
            <div class="card-body">
              <p class="text-muted">Export all visitor logs to an Excel spreadsheet for further analysis or record keeping.</p>
              <form method="POST" action="includes/export-excel.php" class="form-inline">
                <div class="form-group mr-3">
                  <label for="export_from" class="mr-2">From Date:</label>
                  <input type="date" class="form-control" id="export_from" name="export_from">
                </div>
                <div class="form-group mr-3">
                  <label for="export_to" class="mr-2">To Date:</label>
                  <input type="date" class="form-control" id="export_to" name="export_to">
                </div>
                <button type="submit" class="btn btn-success">
                  <i class="fas fa-download"></i> Export to Excel
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
        <script src="js/dashboard.js"></script>
  </body>
</html>