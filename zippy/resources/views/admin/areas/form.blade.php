{!!  HTML::vtext('name', null, ['label' => 'Area Name', 'id' => 'autocomplete']) !!}
{!!  HTML::vtext('zipcode', null, ['id' => 'postal_code']) !!}

<div class=" m-portlet__foot--fit">
    <div class="m-form__actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{route('admin.areas.index')}}" type="reset" class="btn btn-secondary">Cancel</a>
    </div>
</div>