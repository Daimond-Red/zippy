<div class="m-portlet__body table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-default">
        <tr>
            <th>ID</th>
            <th>User Type</th>
            {{-- <th>Image</th> --}}
            <th>Name</th>
            <th>Email</th>
            <th>Mobile No</th>
        </tr>
        </thead>
        <tbody>
        @if(! count($collection) )
            <tr>
                <td colspan="50">No records found</td>
            </tr>
        @endif
        @foreach( $collection as $model )
            <tr>
                <th scope="row">{{ $model->id }}</th>
                <td>
                    @if( $model->role == \App\User::VENDOR )
                        <span class="m-badge m-badge--info m-badge--wide">VENDOR</span>
                    @elseif( $model->role == \App\User::CUSTOMER )
                        <span class="m-badge m-badge--primary m-badge--wide">CUSTOMER</span>
                    @elseif( $model->role == \App\User::DRIVER )
                        <span class="m-badge m-badge--default m-badge--wide">DRIVER</span>
                    @endif
                </td>
                {{-- <td class="customer-info">
                    <a href="{{ getImageUrl($model->image) }}" class="light-image">
                        <img style="width: 40px; height:40px" src="{{ getImageUrl($model->image) }}" >
                    </a>
                </td> --}}
                <td>{{ $model->first_name }} {{ $model->last_name }} </td>
                <td>{{ $model->email }} </td>
                <td>{{ $model->mobile_no }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>