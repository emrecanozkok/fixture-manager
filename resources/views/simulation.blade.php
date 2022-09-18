@extends('master')
@section('content')
    <h3 class="text-center">Generated Fixtures</h3>
    <div class="row">

        <div class="col-md-6">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-dark text-white">
                        <th scope="col ">Team Name</th>
                        <th scope="col ">P</th>
                        <th scope="col ">W</th>
                        <th scope="col ">D</th>
                        <th scope="col ">L</th>
                        <th scope="col ">GD</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($scoreBoard as $team)
                        <tr>
                            <td>{{$team['team_name']}}</td>
                            <td>{{$team['p']}}</td>
                            <td>{{$team['w']}}</td>
                            <td>{{$team['d']}}</td>
                            <td>{{$team['l']}}</td>
                            <td>
                                @if($team['gf'] != 0 || $team['gf'] != 0)
                                    {{$team['gf'] / $team['gf']}}
                                @else
                                    0
                                @endif</td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    @if($nextWeek != false)
                    <table class="table table-bordered">
                        <thead>
                        <tr class="bg-dark text-white">
                            <th scope="col ">Week {{$nextWeek}}</th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($nextWeekData as $match)
                                <tr>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-5 text-start">{{$match->homeTeam->team_name}}</div>
                                                <div class="col-md-2 text-center">-</div>
                                                <div class="col-md-5 text-end">{{$match->awayTeam->team_name}}</div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    @else
                        <h3 class="text-center">No Week Left</h3>
                    @endif
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="bg-dark text-white">
                            <th scope="col ">Champion Predictions</th>
                            <th scope="col ">%</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($prediction as $team)
                            <tr>
                                <td>{{$team['team_name']}}</td>
                                <td>{{number_format($team['percent'], 2, '.', '')}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="row border-top" style="padding-top:20px;">
        <div class="col-md-4">
            <div class="text-center">
                <a href="{{route('simulation.playallweeks')}}" class="btn btn-primary" type="button">Play All Weeks</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <a href="{{route('simulation.playnextweek')}}" class="btn btn-primary" type="button">Play Next Week</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <a href="{{route('simulation.resetdata')}}" class="btn btn-danger" type="button">Reset Data</a>
            </div>
        </div>
    </div>

@endsection
