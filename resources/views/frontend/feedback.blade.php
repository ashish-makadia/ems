@extends('frontend_layout.app')
@section('subheader',"Customer")
@section('content')

<html>
    <head>
    <style>
       .container.main {
   width: 80%;
   padding: 50px 0;
   margin: 50px auto;
   position: relative;
   overflow: hidden;
}

.container.main:before {
   content: '';
   position: absolute;
   top: 0;
   left: 50%;
   margin-left: -1px;
   width: 2px;
   height: 100%;
   background: #CCD1D9;
   z-index: 1
}

.timeline-block {
   width: -webkit-calc(50% + 8px);
   width: -moz-calc(50% + 8px);
   width: calc(50% + 8px);
   display: -webkit-box;
   display: -webkit-flex;
   display: -moz-box;
   display: flex;
   -webkit-box-pack: justify;
   -webkit-justify-content: space-between;
   -moz-box-pack: justify;
   justify-content: space-between;
   clear: both;
}

.timeline-block-right {
   float: right;
}

.timeline-block-left {
   float: left;
   direction: rtl
}

.marker {
   width: 16px;
   height: 16px;
   border-radius: 50%;
   border: 2px solid #F5F7FA;
   background: #4FC1E9;
   margin-top: 10px;
   z-index: 9999
}

.timeline-content {
   width: 95%;
   padding: 0 15px;
   color: #666
}

.timeline-content h3 {
   margin-top: 5px;
   margin-bottom: 5px;
   font-size: 25px;
   font-weight: 500
}

.timeline-content span {
   font-size: 15px;
   color: #a4a4a4;
}

.timeline-content p {
   font-size: 14px;
   line-height: 1.5em;
   word-spacing: 1px;
   color: #888;
}


@media screen and (max-width: 768px) {
   .container.main:before {
      left: 8px;
      width: 2px;
   }
   .timeline-block {
      width: 100%;
      margin-bottom: 30px;
   }
   .timeline-block-right {
      float: none;
   }

   .timeline-block-left {
      float: none;
      direction: ltr;
   }
}
     </style>
    </head>
    <body>


        <div class="container main">
           @foreach ($customerSup as $key => $item)
                @if($key%2 == 0)
                    @php $class= "timeline-block-right" @endphp
                @else
                    @php $class= "timeline-block-left" @endphp
                @endif
                <div class="timeline-block {{ $class }}">
                        <div class="marker"></div>
                        <div class="timeline-content">
                        <h3>{{ $item->subject}}</h3>
                        <span>{{ date('d M Y',strtotime($item->delivery_date))}}</span>
                        <p>{{ strlen($item->Description)>5?substr($item->Description,0,100).'...':$item->Description;  }}</p>
                        @if($item->status=='Open')
							<span class="badge bg-success bg-sm text-white ">Approved</span>
						@else
                            <span class="badge bg-primary bg-sm text-white">Reject</span>
                        @endif
                        <br/><a class="btn btn-sm btn-secondary mt-1" href="{{url(("/customerfeedback/$item->ticket_id"))}}">Read More</a>
                        </div>
                    </div>
           @endforeach
{{--

           <div class="timeline-block timeline-block-left">
              <div class="marker"></div>
              <div class="timeline-content">
                 <h3>Seconed Year</h3>
                 <span>Some work experience</span>
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.</p>
              </div>
           </div>

           <div class="timeline-block timeline-block-right">
              <div class="marker"></div>
              <div class="timeline-content">
                 <h3>Third Year</h3>
                 <span>Some work experience</span>
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.</p>
              </div>
           </div>

           <div class="timeline-block timeline-block-left">
              <div class="marker"></div>
              <div class="timeline-content">
                 <h3>Fourth Year</h3>
                 <span>Some work experience</span>
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.</p>
              </div>
           </div>

           <div class="timeline-block timeline-block-right">
              <div class="marker"></div>
              <div class="timeline-content">
                 <h3>Fifth Year</h3>
                 <span>Some work experience</span>
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.</p>
              </div>
           </div> --}}
        </div>
    </body>
</html>
@endsection
