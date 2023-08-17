@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(session()->has('success'))
            <div class="alert alert-warning alert-dismissible mx-3 fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="col-md-10">

            <button class="btn btn-primary mb-3"
                    data-bs-toggle="modal"
                    data-bs-target="#addModal"
                    onclick="AddMeeting()"
            >Create Meeting</button>
            <div class="card">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Sr#</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Start</th>
                        <th scope="col">end</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($meetings as $meeting)
                        <tr>
                            <td>{{ $meeting->id }}</td>
                            <td>{{ $meeting->subject }}</td>
                            <td>{{ $meeting->start_time }}</td>
                            <td>{{ $meeting->end_time }}</td>
                            <td class="nowrap">
                                <button
                                    onclick="EditMeeting('{{ route('meetings.update',$meeting->id) }}','{{ route('meetings.edit',$meeting->id) }}')"
                                    class="btn btn-warning btn-sm px-1 py-0 ml-2 mr-2"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="OpenDeleteModel('{{ route('meetings.destroy',$meeting->id) }}')"
                                   class="btn btn-danger btn-sm px-1 py-0"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">
                                No data available in table
                            </td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
                {{ $meetings->onEachSide(2)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection
@section('models')
    @include('components.addModal')
    @include('components.updateModal')
    @include('components.delete')
@endsection
@push('script')
    @if(session()->has('addMeeting'))

        <script>
            $(document).ready(function () {
                $('#addModal').modal('show')
            })
        </script>
    @endif
    @if(session()->has('updateMeeting'))
        <script>
            $(document).ready(function () {
                $('#updateModal').modal('show')
            })
        </script>
    @endif
    <script src="{{asset('assets/meeting.js')}}"></script>
@endpush
