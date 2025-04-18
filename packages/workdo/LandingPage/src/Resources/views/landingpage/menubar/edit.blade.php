{{ Form::model(null, ['route' => ['custom_page.update', $key], 'method' => 'PUT']) }}
    @csrf
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('menubar_page_name', __('Page Name'), ['class' => 'form-label']) }}
            {{ Form::text('menubar_page_name', $page['menubar_page_name'], ['class' => 'form-control font-style', 'placeholder' => __('Enter Plan Name'), 'required' => 'required', 'id' => 'menubar_page_name']) }}
        </div>
        <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="template_name" value="page_content" id="page_content"
                    data-name="page_content"
                    {{ isset($page['template_name']) && $page['template_name'] == 'page_content' ? "checked = 'checked'" : '' }}>
                <label class="form-check-label" for="page_content">
                    {{ __('Page Content') }}
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="template_name" value="page_url" id="page_url"
                    data-name="page_url"
                    {{ isset($page['template_name']) && $page['template_name'] == 'page_url' ? "checked = 'checked'" : '' }}>
                <label class="form-check-label" for="page_url">
                    {{ __('Page URL') }}
                </label>
            </div>
        </div>

        <div class="form-group col-md-12 page_content">
            {{ Form::label('menubar_page_contant', __('Page Content'), ['class' => 'form-label']) }}
            {!! Form::textarea(
                'menubar_page_contant',
                isset($page['menubar_page_contant']) && !empty($page['menubar_page_contant']) ? $page['menubar_page_contant'] : '',
                [
                    'class' => 'form-control summernote-simple',
                    'id' => 'menubar_page_contant',
                    'rows' => '5',
                ],
            ) !!}
        </div>

        <div class="form-group col-md-12 page_url">
            {{ Form::label('page_url', __('Page URL'), ['class' => 'form-label']) }}
            {{ Form::text('page_url', isset($page['page_url']) && !empty($page['page_url']) ? $page['page_url'] : '', ['class' => 'form-control font-style', 'placeholder' => __('Enter Page URL'),'id' => 'page_url']) }}
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="form-check form-switch ml-1">
                <input type="checkbox" class="form-check-input" id="cust-theme-bg" name="header"
                    {{ $page['header'] == 'on' ? 'checked' : '' }} />
                <label class="form-check-label f-w-600 pl-1" for="cust-theme-bg">{{ __('Header') }}</label>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="form-check form-switch ml-1">
                <input type="checkbox" class="form-check-input" id="login"
                    name="login"{{ $page['login'] == 'on' ? 'checked' : '' }} />
                <label class="form-check-label f-w-600 pl-1" for="login">{{ __('Login') }}</label>
            </div>
        </div>
        <div class="col-lg-3  col-md-6 mb-3">
            <div class="form-check form-switch ml-1">
                <input type="checkbox" class="form-check-input" id="cust-darklayout"
                    name="footer"{{ $page['footer'] == 'on' ? 'checked' : '' }} />
                <label class="form-check-label f-w-600 pl-1" for="cust-darklayout">{{ __('Footer') }}</label>
            </div>
        </div>
    </div>
    <div class="modal-footer pb-0">
        <input type="button" value="{{ __('Cancel') }}" class="btn btn-badge btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Update') }}" class="btn btn-badge mx-1 btn-primary">
    </div>
{{ Form::close() }}

<script>
    tinymce.init({
        selector: '#mytextarea',
        menubar: '',
    });
    $(document).ready(function() {
        $('input[name="template_name"]:checked').trigger('change');
    });
    $('input[name="template_name"]').change(function() {
        var radioValue = $('input[name="template_name"]:checked').val();
        var page_url = $('.page_url');
        var page_content = $('.page_content');

        if (radioValue === "page_content") {
            page_content.show();
            page_url.hide();
        } else {
            page_content.hide();
            page_url.show();
        }
    });
</script>
