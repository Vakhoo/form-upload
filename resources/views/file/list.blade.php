<!-- resources/views/files/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Manage Files</div>

                    <div class="card-body">
                        @if($files->isEmpty())
                            <div class="alert alert-info">No files uploaded yet.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Uploaded At</th>
                                        <th>Expires at</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($files as $file)
                                        <tr data-file-id="{{ $file->id }}">
                                            <td>{{ $file->filename }}</td>
                                            <td>{{ $file->created_at->format('Y-m-d H:i') }}</td>
                                            <td>{{ $file->created_at->addSeconds(config('custom.file.expire_time'))->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                        data-file-id="{{ $file->id }}"
                                                href="{{ $file->url }}" target="_blank">
                                                    View
                                                </a>
                                                <button class="btn btn-danger btn-sm delete-file"
                                                        data-url="{{ route('file.delete', ['fileId' => $file->id]) }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-4">
                                    {!! $files->links() !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-file').click(function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                const $row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this file?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $row.fadeOut(300, function() {
                                $(this).remove();
                            });
                        },
                        error: function(xhr) {
                            alert('Error deleting file: ' + xhr.responseJSON?.message);
                        }
                    });
                }
            });
        });
    </script>
@endsection
