@extends('master')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="col-md-3">
            <h3>Tournament Teams</h3>
            <table class="table table-bordered">
                <thead>
                <tr class="bg-dark text-white">
                    <th scope="col ">Team Name</th>

                </tr>
                </thead>
                <tbody>

                @foreach($teams as $team)
                <tr>
                    <td>{{$team->team_name}}</td>

                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-grid gap-2">
                <a href="{{route('fixture.generate')}}" class="btn btn-primary" type="button">Generate Fixtures</a>
            </div>
        </div>
    </div>
@endsection
