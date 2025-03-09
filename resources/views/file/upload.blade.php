<!-- resources/views/upload.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Upload File</div>

                    <div class="card-body">
                        <form id="uploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileInput" name="file" accept=".pdf,.docx" required>
                                    <label class="custom-file-label" for="fileInput">Choose file (PDF/DOCX, max 10MB)</label>
                                </div>
                                <small class="form-text text-muted">Maximum file size: 10MB</small>
                            </div>

                            <div class="progress mb-3" style="display: none;">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>

                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>

                        <div id="message" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // File upload handler
            $('#uploadForm').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const $progress = $('.progress');
                const $progressBar = $('.progress-bar');
                const $message = $('#message');
                const $fileInput = $('#fileInput');

                // Reset UI state
                $progress.show();
                $message.removeClass('alert alert-success alert-danger').html('');
                $progressBar.css('width', '0%').text('0%');

                // AJAX request
                $.ajax({
                    url: "{{ route('file.store') }}", // Make sure this matches your route name
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        const xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                const percent = Math.round((e.loaded / e.total) * 100);
                                $progressBar.css('width', percent + '%').text(percent + '%');
                            }
                        });
                        return xhr;
                    },
                    success: function(response) {
                        $message.html(`
                    <div class="alert alert-success">
                        ${response.message || 'File uploaded successfully! It will be automatically deleted in 24 hours.'}
                    </div>
                `);
                        $('#uploadForm')[0].reset();
                        $fileInput.next('.custom-file-label').html('Choose file');
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred during upload.';
                        if (xhr.status === 422) { // Validation error
                            errorMessage = xhr.responseJSON.errors.file[0];
                        } else if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        $message.html(`
                    <div class="alert alert-danger">
                        ${errorMessage}
                    </div>
                `);
                    },
                    complete: function() {
                        $progress.hide();
                        $progressBar.css('width', '0%').text('');
                    }
                });
            });

            // Update file input label
            $('#fileInput').change(function() {
                const fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName || 'Choose file');
            });
        });
    </script>
@endsection
