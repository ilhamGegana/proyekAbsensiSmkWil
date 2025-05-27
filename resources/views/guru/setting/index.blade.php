{{-- @extends('guru/template/template')

@section('style')
  <style>
    #attendanceTable {
      font-size: 24px;
      font-weight: 400;
    }

    .btn-update {
      background-color: #294A9B;
      color: white;
      width: 297px;
      font-size: 24px;
      font-weight: 400;
      height: 84px;
    }

    .label-student {
      font-size: 24px;
      font-weight: 400;
    }

    .card-header {
      min-height: 112px;
      color: white;
      background-color: white;
    }

    .card-footer {
      min-height: 112px;
      color: white;
      background-color: white;
    }

    .header-form {
      font-size: 40px;
      font-weight: 500;
    }

    .user-image {
      width: 250px;
      height: 250px;
      border: 1px solid #000;
      /* Added 1px border with black color */
      border-radius: 50%;
    }

    .btn-input {
      background-color: white;
      color: black;
      width: 188px;
      font-size: 24px;
      font-weight: 400;
      height: 60px;
      display: inline-block;
      text-align: center;
      /* Vertically center text */
      cursor: pointer;
      border: 1px solid #000;
    }

    input[type="file"] {
      display: none;
      /* Hide the default file input */
    }

    #container-form {
      flex-direction: row;
    }

    @media (max-width: 767px) {
      .user-image {
        width: 150px;
        height: 150px;
        border: 1px solid #000;
        /* Added 1px border with black color */
        border-radius: 50%;
      }

      #container-form {
        flex-direction: column;
      }
    }
  </style>
@endsection

@section('content')
  <div class="container-header mb-5">Settings</div>

  <div class="container p-0">
    <div class="card">
      <div class="card-header">
        <p class="m-0 header-form">
          Profile Settings
        </p>
      </div>
      <div class="card-body">
        <!-- Success Alert -->
        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
          </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('setting.update') }}" method="POST" enctype='multipart/form-data'>
          @csrf
          @method('PUT')
          <div class="d-flex gap-5 px-3 pb-5 pt-3" id="container-form">
            <div class="d-flex flex-column gap-3 justify-center align-items-center">
              <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}" class="user-image">
              <label for="image" class="btn btn-input">Upload</label>
              <input type="file" name="image" id="image" class="btn-input" style="display: none;">
            </div>
            <div class="flex-grow-1">
              <div class="form-group mt-3 mb-3">
                <label for="email" class="label-student">Email :</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
              </div>
              <div class="form-group mb-3">
                <label for="new_password" class="label-student">New Password :</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
              </div>
              <div class="form-group mb-3">
                <label for="confirm_password" class="label-student">Confrim Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
              </div>
            </div>
          </div>
      </div>
      <div class="card-footer text-center py-3">
        <button type="submit" class="btn btn-update">Save Changes</button>
      </div>
      </form>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#attendanceTable').DataTable();

      // Form submission with password validation
      $('form').submit(function(event) {
        var password = $('#new_password').val();
        var confirmPassword = $('#confirm_password').val();

        // Check if password is at least 8 characters long
        if (password.length > 1 && password.length < 8) {
          alert('Password must be at least 8 characters long.');
          event.preventDefault(); // Prevent form submission
          return false;
        }

        // Check if passwords match
        if (password !== confirmPassword) {
          alert('Password and confirmation password must match.');
          event.preventDefault(); // Prevent form submission
          return false;
        }
      });
    });
  </script>
@endsection --}}

@extends('guru/template/template')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Setting</h6>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-4 text-center">
                    <div class="mb-3">
                        <img src="{{ Storage::url($user->image) }}" 
                             alt="{{ $user->name }}" 
                             class="img-profile rounded-circle"
                             style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #4e73df;">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="btn btn-outline-primary">
                            <i class="fas fa-upload"></i> Upload Foto
                        </label>
                        <input type="file" 
                               name="image" 
                               id="image" 
                               class="d-none"
                               accept="image/*">
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="form-group">
                        <label class="small font-weight-bold">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ $user->email }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Password Baru</label>
                        <input type="password" 
                               class="form-control @error('new_password') is-invalid @enderror" 
                               id="new_password" 
                               name="new_password"
                               minlength="8">
                        <small class="form-text text-muted">
                            Biarkan kosong jika tidak ingin mengubah password
                        </small>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Konfirmasi Password</label>
                        <input type="password" 
                               class="form-control @error('confirm_password') is-invalid @enderror" 
                               id="confirm_password" 
                               name="confirm_password">
                        @error('confirm_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Preview image before upload
    $("#image").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.img-profile').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Form validation
    $("#settingsForm").submit(function(event) {
        var password = $('#new_password').val();
        var confirmPassword = $('#confirm_password').val();

        if (password) {
            if (password.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Password harus minimal 8 karakter!'
                });
                event.preventDefault();
                return false;
            }

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Password dan konfirmasi password tidak cocok!'
                });
                event.preventDefault();
                return false;
            }
        }
    });
});
</script>
@endsection