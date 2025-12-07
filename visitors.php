<?php
session_start();
include 'includes/check-session.php';

$page='Visitors';

include 'includes/visitors.php';
$visitors = getAllVisitors();
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
        <h1 class="h2">Visitor Logs</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="visitor-form.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Visitor
          </a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Visitor Name</th>
              <th>Date</th>
              <th>Time</th>
              <th>Contact</th>
              <th>Office</th>
              <th>Purpose</th>
              <th>Recorded By</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $counter = 0;
              foreach($visitors as $visitor) {
                $counter+=1;
                $purpose_display = ucfirst($visitor['purpose']);
            ?>
            <tr>
              <td><?=$counter?></td>
              <td><?=$visitor['visitor_name']?></td>
              <td><?=date("M d, Y", strtotime($visitor['date_of_visit']))?></td>
              <td><?=date("h:i A", strtotime($visitor['time_of_visit']))?></td>
              <td><?=$visitor['contact_number']?></td>
              <td><?=$visitor['school_office']?></td>
              <td><span class="badge badge-info"><?=$purpose_display?></span></td>
              <td><?=$visitor['created_by_name'] ?? 'Unknown'?></td>
              <td>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-primary btn-sm">
                    <a href="visitor-form.php?id=<?=$visitor['id']?>" class="text-white"><i class="fas fa-pen"></i></a>
                  </label>
                  <label class="btn btn-danger btn-sm">
                    <a href="#" onclick="deleteVisitor(<?=$visitor['id']?>)" class="text-white"><i class="fas fa-trash"></i></a>
                  </label>
                </div>
              </td>
            </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
        <script src="js/dashboard.js"></script>

        <script>
          function deleteVisitor(id) {
            if (confirm('Are you sure you want to delete this visitor record?')) {
              window.location.href = 'includes/delete-visitor.php?id=' + id;
            }
          }
        </script>
  </body>
</html>
