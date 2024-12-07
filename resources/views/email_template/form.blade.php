<div class="row">
    <div class="ajaxLoading text-center" style="display:none;width:100%">
        <i class="fa fa-spinner fa-spin fa-3x fa-fw text-maroon"></i>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="category_id">Template Type</label>
            <select class="form-control" name="template_type_id">
                <option value="">Select Type</option>
                 @foreach ($template_type as $key =>  $val)
                 <option value="{{ $key }}"
                    {{ @@$email_template->template_type_id?($email_template->template_type_id==$key?"selected":""):""}}>{{$val}}</option>
                        @endforeach
                 </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nome">Subject</label>
                                <input type="text" name="subject" class="form-control" placeholder="{{__('messages.subject')}}" value="{{ ((isset($email_template)) ? $email_template->subject : old('subject')) }}" >

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nome">Content</label>
                                <input type="text" name="sms_content" class="form-control"  placeholder="Sms Content"  value="{{ ((isset($email_template)) ? $email_template->sms_content : old('sms_content')) }}" >

        </div>
    </div>
</div>

<!-- Start Row  -->
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="nome">{{__('messages.content')}}</label>
            <textarea id="editor2" name="content" class="form-control"  placeholder="Content">{{  ((isset($email_template)) ? $email_template->content : old('content')) }}  </textarea>


        </div>
    </div>

</div>
<!-- End Row  -->
