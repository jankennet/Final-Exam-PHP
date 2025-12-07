 <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link <?=$page=='dashboard'?'active':''?>" href="dashboard.php">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link <?=$page=='Visitors'?'active':''?>" href="visitors.php">
              <span data-feather="users"></span>
              Visitor Logs
            </a>
          </li>
          
           <li class="nav-item">
            <a class="nav-link <?=$page=='New Visitor'?'active':''?>" href="visitor-form.php">
              <span data-feather="plus-circle"></span>
              Add New Visitor
            </a>
          </li>
        </ul>
      </div>
    </nav>