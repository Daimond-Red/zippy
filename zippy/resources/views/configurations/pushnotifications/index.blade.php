@extends('configurations.layouts.master')

@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Push Notification</li>
    </ol>

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-gears"></i> Push Configurations - Customer </div>

                <div class="card-body">
                    {{ Form::open( [  'route' => 'config.push_user1_store', 'method' => 'POST', 'files' => true ]) }}

                        <div class="form-group">
                            <label for="sandbox-user1-pem">IOS Firebase API Key</label>
                            <textarea rows="4" class="form-control" name="ios_firebase_api_user1" id="user1-ios-firebase-api" >{{ $ios_firebase_api_user1 }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="sandbox-user1-pem">Android Firebase API Key</label>
                            <textarea rows="4" class="form-control" name="android_firebase_api_user1" id="user1-android-firebase-api" >{{ $android_firebase_api_user1 }}</textarea>
                        </div>

                        <input type="submit" class="btn btn-primary btn-block" value="Save Configuration" />

                    </form>
                </div>
                <div class="card-footer small text-muted"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-gears"></i> Push Configurations - Partner </div>
                <div class="card-body">

                   {{ Form::open( [  'route' => 'config.push_user2_store', 'method' => 'POST', 'files' => true ]) }}

                        <div class="form-group">
                            <label for="sandbox-user1-pem">IOS Firebase API Key</label>
                            <textarea rows="4" class="form-control" name="ios_firebase_api_user2" id="user2-ios-firebase-api" >{{ $ios_firebase_api_user2 }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="sandbox-user1-pem">Android Firebase API Key</label>
                            <textarea rows="4" class="form-control" name="android_firebase_api_user2" id="user2-android-firebase-api" >{{ $android_firebase_api_user2 }}</textarea>
                        </div>

                        <input type="submit" class="btn btn-primary btn-block" value="Save Configuration" />

                    {{ Form::close() }}
                </div>
                <div class="card-footer small text-muted"></div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('.pushconfig-menu').addClass('active');
        });
    </script>
@stop