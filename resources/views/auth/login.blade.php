
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE-Edge"/>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
  <link rel="icon" href="images/kaiadmin/favicon.ico" type="image/x-icon"/>
  <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"]},
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
          ],
        urls: ["{{ asset('assets/css/fonts.min.css') }}", "css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}"/>
  <title>Login Kaiadmin</title>
</head>
<body class="login bg-primary">
  <div class="wrapper wrapper-login">
    <div class="container container-login animated fadeIn">
      <h3 class="text-center">LogIn</h3>
      <form id="formloginuser" name="formloginuser" method="POST" action="{{ route('login.submit') }}" role="form">
    @csrf
    <div class="login-form">
        <div class="form-sub">
            <div class="form-floating form-floating-custom mb-3">
                <input type="text" id="username" name="username" class="form-control"
                       placeholder="Username" required />
                <label for="username">Username</label>
            </div>
            <div class="form-floating form-floating-custom mb-3 position-relative">
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="Password" required />
                <label for="password">Password</label>
                <div class="show-password" style="position: absolute; right: 15px; top: 15px; cursor: pointer;">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="form-action mb-3">
            <button type="submit" id="btnform" name="btnform" class="btn btn-primary w-100 btn-login">Login</button>
        </div>
    </div>
</form>


    </div>
  </div>
  <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/jquery.validate/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = "{{ url('dashboard') }}";
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login gagal',
        text: '{{ session('error') }}'
    });
</script>
@endif

  </body>
</html>