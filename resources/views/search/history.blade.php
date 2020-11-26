@extends('master')
@section('body')
<div id="main" class="search_page">
    <h3>Search History</h3>

    <div id="divSearch_history_table">
        <table id="search__history_table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Search URL</th>
                    <th>Performed By</th>
                    <th>Performed At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($search_history as $history)
                    <tr>
                        <td>{{ $history['search_url'] }}</td>
                        <td>{{ $history['user_name'] }}</td>
                        <td>{{ $history['timestamp'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection