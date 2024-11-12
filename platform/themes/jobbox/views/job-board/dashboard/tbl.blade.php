@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-end mb-2 block">
                    <a href="{{ route('public.account.consultant-packages.create') }}" class="btn btn-success">Create</a>
                </div>
                <table class="table border shadow">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Credit</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->credits }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <small style="font-size: 10px" ">{{ formatTime($item->start_time) }}</small>
                                        <strong> To</strong>
                                        <small style="font-size: 10px" ">{{ formatTime($item->end_time) }}</small>
                                </td>
                                <td>
                                    <div class="d-flex flex-row">
                                        <a href="{{ route('public.account.consultant-packages.edit', ['consultantPackage' => $item]) }}"
                                            class="btn btn-sm btn-info text-sm rounded me-2">Edit</a>

                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('public.account.consultant-packages.destroy', ['consultantPackage' => $item]) }}"
                                            method="POST" onsubmit="return confirmDelete(this);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-danger text-sm rounded">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            function confirmDelete(form) {
                return confirm("Are you sure you want to delete this item?");
            }
        </script>
    @endsection
