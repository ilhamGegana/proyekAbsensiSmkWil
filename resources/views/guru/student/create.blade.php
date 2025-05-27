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
  </style>
@endsection

@section('content')
  <div class="container-header mb-5">Student</div>

  <div class="container p-0">
    <div class="card">
      <div class="card-header"></div>
      <div class="card-body">
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

        <form action="{{ route('student.store') }}" method="POST">
          @csrf
          <div class="form-group mt-3 mb-3">
            <label for="name" class="label-student">Name :</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group mb-3">
            <label for="class" class="label-student">Class :</label>
            <input type="text" class="form-control" id="class" name="class">
          </div>
          <div class="form-group mb-3">
            <label for="student_id" class="label-student">Student ID</label>
            <input type="text" class="form-control" id="student_id" name="student_id">
          </div>
      </div>
      <div class="card-footer text-center py-3">
        <button type="submit" class="btn btn-update">Save</button>
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
    });
  </script>
@endsection --}}

@extends('guru/template/template')

@section('title', 'Tambah Siswa')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Create Student</h6>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('student.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold">Name Student</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="Input Name Student">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold">Student ID</label>
                        <input type="text" 
                               class="form-control @error('student_id') is-invalid @enderror" 
                               id="student_id" 
                               name="student_id" 
                               value="{{ old('student_id') }}"
                               placeholder="Input Student ID">
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

           <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="small font-weight-bold">Class</label>
            <input type="text" 
                   class="form-control @error('class') is-invalid @enderror" 
                   id="class" 
                   name="class"
                   value="{{ old('class') }}"
                   placeholder="Input Class">
            @error('class')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

            <hr>
            
            <div class="text-right">
                <a href="{{ route('student.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Form validation
        $('form').on('submit', function() {
            $(this).find('button[type="submit"]').attr('disabled', true);
        });
    });
</script>
@endsection