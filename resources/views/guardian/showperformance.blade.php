@extends('guardian.main_layout_guardian')

@section('style', asset('profilestyling/profilestyle.css'))

@section('css')
@endsection
@section('title')
    Guardian -
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                {{-- menu bar will be added here --}}
                <button type="button" onclick="window.location.href='/performance'" class="profilebtn">Back</button>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <div class="container my-4">

                    @foreach ($student->performances as $performance)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>{{ $performance->course->title }}</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Assessment ID</th>
                                            <td>{{ $performance->assessment->id }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Obtained Marks</th>
                                            <td>{{ $performance->obtained_marks }}/{{ $performance->assessment->Total_Marks }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Remarks</th>
                                            <td>{{ $performance->remarks }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
