{{ Form::open(array('route' => 'custom_page.store', 'method'=>'post', 'enctype' => "multipart/form-data")) }}
    @csrf
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('menubar_page_name',__('Page Name'),['class'=>'form-label'])}}
            {{Form::text('menubar_page_name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter Plan Name'),'required'=>'required','id'=>'menubar_page_name'))}}
        </div>
        <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="template_name" value="page_content"
                        id="page_content" data-name="page_content">
                <label class="form-check-label" for="page_content">
                    {{ 'Page Content' }}
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="template_name" value="page_url" id="page_url"
                        data-name="page_url">
                <label class="form-check-label" for="page_url">
                    {{ 'Page URL' }}
                </label>
            </div>
        </div>

        <div class="form-group col-md-12 page_url d-none">
            {{ Form::label('page_url', __('Page URL'), ['class' => 'form-label']) }}
            {{ Form::text('page_url', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter Page URL'),'id'=>'page_url']) }}
        </div>

        <div class="form-group col-md-12 page_content">
            {{ Form::label('menubar_page_contant', __('Page Content'), ['class' => 'form-label']) }}
            {!! Form::textarea('menubar_page_contant', null, [
                'class' => 'form-control summernote-simple',
                'id' => 'menubar_page_contant',
                'rows' => '5',
            ]) !!}
        </div>

        <div class="col-lg-2 col-xl-2 col-md-2 col-6 mb-3">
            <div class="form-check form-switch ml-1">
                <input type="checkbox" class="form-check-input" id="cust-theme-bg" name="header" />
                <label class="form-check-label f-w-600 pl-1" for="cust-theme-bg" >{{__('Header')}}</label>
            </div>
        </div>
        <div class="col-lg-2 col-xl-2 col-md-2 col-6 mb-3">
            <div class="form-check form-switch ml-1">
                <input type="checkbox" class="form-check-input" id="login" name="login" />
                <label class="form-check-label f-w-600 pl-1" for="login" >{{__('Login')}}</label>
            </div>
        </div>
        <div class="col-lg-2 col-xl-2 col-md-2 col-6 mb-3">
            <div class="form-check form-switch ml-1">
                <input type="checkbox" class="form-check-input" id="cust-darklayout" name="footer"/>
                <label class="form-check-label f-w-600 pl-1" for="cust-darklayout">{{ __('Footer') }}</label>
            </div>
        </div>
    </div>
    <div class="modal-footer pb-0">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-badge btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn btn-badge mx-1 btn-primary">
    </div>
{{ Form::close() }}

<script>
    tinymce.init({
        selector: '#mytextarea',
        menubar: '',
    });
</script>

<script>
    $(document).ready(function() {
        $('input[name="template_name"][id="page_content"]').prop('checked', true);
        $('input[name="template_name"]').change(function() {
            var radioValue = $('input[name="template_name"]:checked').val();
            var page_content = $('.page_content');
            if (radioValue === "page_content") {
                $('.page_content').removeClass('d-none');
                $('.page_url').addClass('d-none');
            } else {
                $('.page_content').addClass('d-none');
                $('.page_url').removeClass('d-none');
            }
        });
    });
</script>
