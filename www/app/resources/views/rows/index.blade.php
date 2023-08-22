@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Rows</h1>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($rows as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $rows->links() }}
    </div>
@endsection
