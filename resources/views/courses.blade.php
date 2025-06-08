<!DOCTYPE html>
<html>
<head>
    <title>Course Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container">
        <h1 class="text-center mb-4">Course Booking</h1>

        <div class="row">
           @foreach ($courses as $course)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
            <img src="{{asset('20944332.jpg')}}" class="card-img-top" alt="Course Image" >

            <div class="card-body">
                <h5 class="card-title">{{ $course->title }}</h5>
                <p>
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($course->course_date)->format('d M Y') }}<br>
                    <strong>Base Price:</strong> £{{ $course->base_price }}<br>
                    <strong>Registrations:</strong> {{ $course->registrations_count }}<br>
                    <strong>Current Price:</strong> <span class="text-success">£{{ $course->discounted_price }}</span>
                </p>
                 <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#registerModal{{ $course->id }}">
                    Register
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registerModal{{ $course->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $course->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" class="register-form modal-content" data-id="{{ $course->id }}">
                @csrf
               
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel{{ $course->id }}">Register for {{ $course->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <div class="alert alert-danger d-none ajax-error"></div>
                 <div class="alert alert-success d-none ajax-success"></div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Confirm Registration</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.register-form').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let courseId = form.data('id');
        let url = `/register/${courseId}`;
        let formData = form.serialize();
        let modal = form.closest('.modal');
        let errorBox = form.find('.ajax-error');
        let successBox = form.find('.ajax-success');

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                successBox.removeClass('d-none').html(response.message);
                errorBox.addClass('d-none').html('');
                form[0].reset();

                setTimeout(() => {
                    modal.modal('hide');
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                let errors = '';

                if (res && res.errors) {
                    $.each(res.errors, function(key, val) {
                        errors += val + '<br>';
                    });
                } else if (res && res.message) {
                    errors = res.message;
                } else {
                    errors = 'Something went wrong.';
                }

                errorBox.removeClass('d-none').html(errors);
                successBox.addClass('d-none').html('');
            }
        });
    });
});
</script>
