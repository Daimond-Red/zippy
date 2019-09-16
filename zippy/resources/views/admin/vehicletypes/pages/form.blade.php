<div class="row">
    <div class="col-md-6">
        {!!  HTML::vtext('title', null, ['label' => 'Page Title']) !!}
    </div>
    <div class="col-md-6">
        {!!  HTML::vtext('slug', null, ['label' => 'Slug']) !!}
    </div>
</div>

{!!  HTML::vtextarea('body', null, ['label' => 'Page Content', 'class' => 'editor']) !!}