@extends('layouts.test')

@section('title', 'Home')

@section('content')
  <head>
    <style>
      body, body * {
        color: white;
      }
    </style>
  </head>

  <div class="container text-center">
    <h1>Match Betting</h1>
    <table class="table">
      <thead>
        <tr>
          <th>Match</th>
          <th>Scheduled At</th>
          <th>Team 1 Odds</th>
          <th>Team 2 Odds</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($matches as $match)
          <tr>
            <td>{{ $match['name'] }}</td>
            <td>{{ $match['scheduled_at'] }}</td>
            <td>TBD</td>
            <td>TBD</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
