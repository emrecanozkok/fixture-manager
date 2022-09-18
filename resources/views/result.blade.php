@extends('master')
@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="col-md-12">
            <h3 class="text-center">Match Results</h3>
            @foreach($fixture->chunk(3) as $chunked)
                <div class="row">
                @foreach($chunked as $weekCode => $week)
                    <div class="col-md-4">

                        <table class="table table-bordered">
                            <thead>
                            <tr class="bg-dark text-white">
                                <th scope="col ">Week {{$weekCode}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($week as $match)
                                <tr>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-5 text-start">{{$match->homeTeam->team_name}}</div>
                                                <div class="col-md-2 text-center">{{$match->home_score}}-{{$match->away_score}}</div>
                                                <div class="col-md-5 text-end">{{$match->awayTeam->team_name}}</div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                @endforeach
                </div>
            @endforeach
        </div>

    </div>
    <div class="row">
        <div class="text-center">
            <a href="{{route('simulation.index')}}" class="btn btn-primary" type="button">Return Simulation</a>
        </div>
    </div>
@endsection
