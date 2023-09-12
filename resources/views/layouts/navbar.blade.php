  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>

          <span class="nav-item mt-2">Halo, Rizki</span>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <li class="nav-item">
              <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
              </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="javascript:void(0);" id="logoutButton">
                <i class="fas fa-sign-out-alt fa-fw"></i>
                <span>Logout</span>
            </a>
        </li>
      </ul>
  </nav>

  <script>
      $(document).ready(function() {
          $('#logoutButton').click(function(e) {
              e.preventDefault();
              $.ajax({
                  url: '{{ url('logout') }}',
                  method: 'POST',
                  dataType: 'json',
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response) {
                      console.log(response.message);
                      localStorage.removeItem('access_token');
                      window.location.href = '/login';
                  },
                  error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                      alert('Error: Failed to logout. Please try again.');
                  }
              });
          });
      });
  </script>

  <!-- /.navbar -->
