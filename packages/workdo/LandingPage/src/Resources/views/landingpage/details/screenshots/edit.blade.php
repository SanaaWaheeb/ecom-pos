{{Form::model(null, array('route' => array('screenshots_update', $key), 'method' => 'POST','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('Heading', __('Heading'), ['class' => 'form-label']) }}
                {{ Form::text('screenshots_heading',$screenshot['screenshots_heading'], ['class' => 'form-control ', 'placeholder' => __('Enter Heading'),'required'=>'required'])  }}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('screenshot', __('Screenshot'), ['class' => 'form-label']) }}
                <input type="file" name="screenshots" class="form-control">
            </div>
        </div>

    </div>
</div>
<div class="modal-footer pb-0">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-badge btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-badge btn-primary mx-1">
</div>
{{ Form::close() }}
