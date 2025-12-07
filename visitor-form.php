<?php
session_start();
include 'includes/check-session.php';

$page='New Visitor';
include 'includes/visitors.php';

$visitor = null;
$is_edit = false;

// Check if editing
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $is_edit = true;
    $visitor = getVisitorById((int)$_GET['id']);
    if (!$visitor) {
        header('Location: visitors.php');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $visitor_name = $_POST['visitor_name'] ?? '';
    $date_of_visit = $_POST['date_of_visit'] ?? '';
    $time_of_visit = $_POST['time_of_visit'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $school_office = $_POST['school_office'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $purpose_details = $_POST['purpose_details'] ?? '';
    $created_by = $current_user['user_id']; // Get from logged-in user

    if ($is_edit) {
        $result = updateVisitor(
            (int)$_GET['id'],
            $visitor_name,
            $date_of_visit,
            $time_of_visit,
            $address,
            $contact_number,
            $school_office,
            $purpose,
            $purpose_details
        );
    } else {
        $result = addVisitor(
            $visitor_name,
            $date_of_visit,
            $time_of_visit,
            $address,
            $contact_number,
            $school_office,
            $purpose,
            $purpose_details,
            $created_by
        );
    }

    if ($result['success']) {
        header('Location: visitors.php');
        exit;
    }
}
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
        <h1 class="h2"><?=$is_edit ? 'Edit' : 'Add New'?> Visitor Record</h1>        
      </div>

      <div class="row">
        <div class="col-md-8">
          <form method="POST" class="needs-validation" novalidate>
            <div class="form-group">
              <label for="visitor_name">Visitor Name *</label>
              <input type="text" class="form-control" id="visitor_name" name="visitor_name" value="<?=$visitor['visitor_name'] ?? ''?>" required>
              <div class="invalid-feedback">Visitor name is required.</div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="date_of_visit">Date of Visit *</label>
                <input type="date" class="form-control" id="date_of_visit" name="date_of_visit" value="<?=$visitor['date_of_visit'] ?? ''?>" required>
                <div class="invalid-feedback">Date of visit is required.</div>
              </div>
              <div class="form-group col-md-6">
                <label for="time_of_visit">Time of Visit *</label>
                <input type="time" class="form-control" id="time_of_visit" name="time_of_visit" value="<?=$visitor['time_of_visit'] ?? ''?>" required>
                <div class="invalid-feedback">Time of visit is required.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="address">Address *</label>
              <textarea class="form-control" id="address" name="address" rows="2" required><?=$visitor['address'] ?? ''?></textarea>
              <div class="invalid-feedback">Address is required.</div>
            </div>

            <div class="form-group">
              <label for="contact_number">Contact Number *</label>
              <input type="tel" class="form-control" id="contact_number" name="contact_number" value="<?=$visitor['contact_number'] ?? ''?>" required>
              <div class="invalid-feedback">Contact number is required.</div>
            </div>

            <div class="form-group">
              <label for="school_office">School Office/Department *</label>
              <input type="text" class="form-control" id="school_office" name="school_office" value="<?=$visitor['school_office'] ?? ''?>" required>
              <div class="invalid-feedback">School office is required.</div>
            </div>

            <div class="form-group">
              <label for="purpose">Purpose of Visit *</label>
              <select class="form-control" id="purpose" name="purpose" required>
                <option value="">Select a purpose...</option>
                <option value="inquiry" <?=$visitor && $visitor['purpose'] === 'inquiry' ? 'selected' : ''?>>Inquiry</option>
                <option value="exam" <?=$visitor && $visitor['purpose'] === 'exam' ? 'selected' : ''?>>Exam</option>
                <option value="visit" <?=$visitor && $visitor['purpose'] === 'visit' ? 'selected' : ''?>>Visit</option>
                <option value="others" <?=$visitor && $visitor['purpose'] === 'others' ? 'selected' : ''?>>Others</option>
              </select>
              <div class="invalid-feedback">Purpose is required.</div>
            </div>

            <div class="form-group">
              <label for="purpose_details">Purpose Details</label>
              <textarea class="form-control" id="purpose_details" name="purpose_details" rows="3"><?=$visitor['purpose_details'] ?? ''?></textarea>
              <small class="form-text text-muted">Additional details about the visit</small>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> <?=$is_edit ? 'Update' : 'Add'?> Visitor
              </button>
              <a href="visitors.php" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>

    </main>
  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
        <script src="js/dashboard.js"></script>

        <script>
          // Bootstrap form validation
          (function() {
            'use strict';
            window.addEventListener('load', function() {
              var forms = document.querySelectorAll('.needs-validation');
              Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                  if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                  }
                  form.classList.add('was-validated');
                }, false);
              });
            }, false);
          })();
        </script>
  </body>
</html>
