<div class="row">
    <div class="ajaxLoading text-center" style="display:none;width:100%">
        <i class="fa fa-spinner fa-spin fa-3x fa-fw text-maroon"></i>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nome">Company Name</label>
            <input type="text" name="company_name" class="form-control" placeholder="{{__('messages.company_name')}}" value="{{ ((isset($customer)) ? $customer->company_name : old('company_name')) }}">

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" name="category" id="category">
                <option value="">Select Category</option>
                @foreach ($categories as $key => $val)
                <option value="{{ $val->id }}" {{ @$customer->category?($customer->category==$val->id?"selected":""):""}}>{{$val->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="subCategory">Sub-Category</label>
            <select class="form-control" name="subCategory" id="subCategory">
                <option value="">Select Sub-Category</option>
                @foreach ($subcategories as $key => $val)
                <option value="{{ $val->id }}" {{ @$customer->subCategory?($customer->subCategory==$val->id?"selected":""):""}}>{{$val->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="country">Country</label>
            <select class="form-control" name="country" id="country">
                @foreach($country as $key)
                <option value="">Select Country</option>
                <option value="{{ $key->id }}"  {{ @$customer->country?($customer->country== $key->id?"selected":""):""}}>{{ $key->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="region">Region</label>
            <select class="form-control" name="region" id="country">
                <option value="">Select Region</option>
                @foreach($regions as $region)
                <option value="{{ $region->id }}"  {{ @$customer->region?($customer->region== $region->id?"selected":""):""}}>{{ $region->region_name }}</option>
                
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="province">Province</label>
            <select class="form-control" name="province" id="province">
                <option value="">Select Province</option>
                @foreach($province as $data)
                <option value="{{$data->id}}"  {{ @$customer->province?($customer->province== $data->id?"selected":""):""}}>{{$data->province_name}}</option>
                @endforeach
                
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="municipality">Municipality</label>
            <select class="form-control" name="municipality" id="municipality">
                <option value="">Select Municipality</option>
                @foreach($municipality as $data)
                <option value="{{$data->id}}" {{ @$customer->municipality?($customer->municipality== $data->id?"selected":""):""}}>{{$data->municipality_name}}</option>
                @endforeach
                
            </select>
        </div>
    </div>
    <div class="col-md-4">
        
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nome">Address</label>
            <input type="text" name="address" class="form-control" placeholder="{{__('messages.address')}}" value="{{ ((isset($customer)) ? $customer->address : old('address')) }}">

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nome">Zipcode</label>
            <input type="text" name="zipcode" class="form-control" placeholder="{{__('messages.zipcode')}}" value="{{ ((isset($customer)) ? $customer->zipcode : old('zipcode')) }}">

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nome">Company Email</label>
            <input type="text" name="company_email" class="form-control" placeholder="Company Email" value="{{ ((isset($customer)) ? $customer->company_email : old('company_email')) }}">

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nome">Company Phone</label>
            <input type="text" name="company_phone" class="form-control" placeholder="Company Phone" value="{{ ((isset($customer)) ? $customer->company_phone : old('company_phone')) }}">

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nome">Company Mobile</label>
            <input type="text" name="company_mobile" class="form-control" placeholder="Company Mobile" value="{{ ((isset($customer)) ? $customer->company_mobile : old('company_mobile')) }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nome">Company Website</label>
            <input type="text" name="website" class="form-control" placeholder="Company Website" value="{{ ((isset($customer)) ? $customer->website : old('website')) }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nome">VAT ID</label>
            <input type="text" name="vat_id" class="form-control" placeholder="VAT ID" value="{{ ((isset($customer)) ? $customer->vat_id : old('vat_id')) }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nome">Fiscal Code</label>
            <input type="text" name="fiscal_code" class="form-control" placeholder="Fiscal Code" value="{{ ((isset($customer)) ? $customer->fiscal_code : old('fiscal_code')) }}">
        </div>
    </div>
</div>

<!-- Start Row  -->
{{--<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="nome">{{__('messages.content')}}</label>
            <textarea id="editor2" name="content" class="form-control" placeholder="Content">{{ ((isset($customer)) ? $customer->content : old('content')) }} </textarea>


        </div>
    </div>

</div>--}}

<!-- End Row  -->