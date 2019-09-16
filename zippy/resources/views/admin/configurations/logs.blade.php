<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<head>
    <title>Api Logs</title>
</head>
<?php
        $update_profile_url = 'http://35.154.145.84/public/api/phlebo/update_profile';
        if( request('not_update_profile') ) {
            $collection = \DB::table('logs')->whereNotIn('url', [$update_profile_url])->orderBy('created_at', 'desc')->paginate(50);
        } else {
            $collection = \DB::table('logs')->orderBy('created_at', 'desc')->paginate(50);
        }

?>

<div id="accordion" role="tablist" style="width: 80%; margin: 0 auto; margin-top: 3%">
    <a href="logs?clear=true" class="btn btn-primary" style="margin-bottom: 10px">Clear Log</a>
@foreach( $collection as $model )
    <div class="card" style="margin-bottom: 5px">
        <div class="card-header" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" href="#collapseOne{{$model->id}}" aria-expanded="false" aria-controls="collapseOne{{$model->id}}" class="collapsed" style="display: block">
                    {{ $model->url }} Created At: {{ date('d-m-Y h:i a', strtotime($model->created_at)) }}
                </a>
            </h5>
        </div>

        <div id="collapseOne{{$model->id}}" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
            <div class="card-body">
                Error: {{ $model->status }}

                <h3>Request JSON</h3>
                <pre>
                    {{ $model->json }}
                </pre>
                <h3>Request Object</h3>
                <pre>
                    <?php print_r(json_decode($model->req, true)) ?>
                </pre>
                <h3>Response JSON</h3>
                <pre>
                    {{ $model->res }}
                </pre>
                <h3>Response Object</h3>
                <pre>
                    <?php print_r(json_decode($model->res, true)) ?>
                </pre>
            </div>
        </div>
    </div>
    @endforeach
        {{ $collection->appends(request()->all())->links() }}
</div>
