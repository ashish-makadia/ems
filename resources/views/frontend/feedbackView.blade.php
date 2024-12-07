@extends('frontend_layout.app')
@section('subheader',"Customer")
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<style>
  .process-table {
    border: 1px solid #ECECEC;font-family: 'Roboto', sans-serif;
    margin: 0 auto;
    width: 50%;
    /* padding: 10px; */
}
.main-left-process i {
    background-color: #017EFA;
    width: 34px;
    height: 34px;
    text-align: center;
    padding-top: 8px;
    font-size: 16px;
    border-radius: 50px;color:#fff;
}
.main-left-process {
    display: flex;font-family: 'Roboto', sans-serif;
    width: 50%;
}
.process-left {
    display: flex;font-family: 'Roboto', sans-serif;
}
.main-right-process {
    text-align: end;font-family: 'Roboto', sans-serif;
    width: 50%;
    padding-top: 15px;
    padding-left: 10px;
}
.main-left-process h2 {
    padding: 3px 13px;font-family: 'Roboto', sans-serif;
    font-size: 24px;    margin-bottom: 0px;
}

.main-left-process {
    padding-top: 10px;
    padding-left: 10px;
    padding-bottom: 10px;font-family: 'Roboto', sans-serif;
}

.main-right-process a {
    color: #017EFA;font-family: 'Roboto', sans-serif;
    font-size: 18px;    padding-right: 10px;
}
.main-right-process a i {
    margin: 5px;
    margin-left: 10px;
}
.process-left {
    display: flex;font-family: 'Roboto', sans-serif;
    border-bottom: 1px solid #ECECEC;
}
.name-proceess {

    font-weight: 400;
    font-size: 18px;
    line-height: 21px;
    color: #67676799;
    font-family: 'Roboto', sans-serif;
font-style: normal;    padding-top: 7px;border-radius: 10px;

}
.name-proceess span {
    color: #1C1F37;font-family: 'Roboto', sans-serif;
}
.main-process-name {
    padding: 10px;font-family: 'Roboto', sans-serif;padding-left: 20px;
}

.cbp_tmtimeline {
  margin: 30px 0 0 0;
  padding: 0;
    list-style: none;
    position: relative;
    margin: 0 auto;

}

/* The line */
.cbp_tmtimeline:before {
  content: "";
  position: absolute;
  top: -30px;
  bottom: 0;
  width: 4px;
    background: #D1D6E6;
    border-radius: 15.6232px;
  left: 28%;
  margin-left: -10px;
}

.cbp_tmtimeline > li {
  position: relative;    padding: 10px;
}

/* The date/time */
.cbp_tmtimeline > li .cbp_tmtime {
  position: absolute;
    font-size: 5px;
    left: -28%;    top: 50px;

}

.cbp_tmtimeline > li .cbp_tmtime span {
  display: block;
  text-align: right;
}

.cbp_tmtimeline > li .cbp_tmtime span:first-child {
  font-family: 'Roboto';
    font-style: normal;
    font-weight: 400;
    font-size: 18px;
    line-height: 21px;
    color: #676767;
}

.cbp_tmtimeline > li .cbp_tmtime span:last-child {
  font-family: 'Roboto';
    font-style: normal;
    font-weight: 400;
    font-size: 18px;
    line-height: 21px;
    color: #676767;
}

.cbp_tmtimeline > li:nth-child(odd) .cbp_tmtime span:last-child {
  font-family: 'Roboto';
    font-style: normal;
    font-weight: 400;
    font-size: 18px;
    line-height: 21px;
    color: #676767;
}

/* Right content */
.cbp_tmtimeline > li .cbp_tmlabel {
  margin: 0 0 15px 30%;
  background: #FFF;
  color: #fff;


  font-weight: 300;
  line-height: 1.4;
  position: relative;
  border-radius: 5px;
  width: 198px;
    height: auto;
    background: #FFFFFF;
    border-radius: 10px;
    box-shadow: 0px 4px 14px rgb(0 0 0 / 6%);    padding: 5px;
    padding-bottom: 1px;
}
.cbp_tmlabel p {
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 142.19%;
    color: #626262;     padding-top: 5px;
    /* padding-bottom: 5px; */
    padding-left: 10px;
}
.main {
    background-color: #F9FBFC;
    position: relative;
    top: 0;
    width: 100%;
    padding: 60px;
    /* margin: 20px; */
    border-radius: 10px;   display: grid;
}
.cbp_tmtimeline > li:nth-child(odd) .cbp_tmlabel {
  background: #FFF;   width: 198px;
    height: auto;
    background: #FFFFFF;
    border-radius: 10px;box-shadow: 0px 4px 14px rgba(0, 0, 0, 0.06);

}

.cbp_tmtimeline > li .cbp_tmlabel h2 {
  margin-top: 0px;
  padding: 11px 0px 0px 10px;
  font-family: 'Roboto';
    font-style: normal;
    font-weight: 600;
    font-size: 18px;
    line-height: 21px;
    color: #1C1F37;
    margin-bottom: 0;
}


.cbp_tmtimeline > li:nth-child(odd) .cbp_tmlabel:after {
  border-right-color: #6cbfee;
}

/* The icons */
.cbp_tmtimeline > li .cbp_tmicon {
  width: 18px;
  height: 18px;
  speak: none;
  font-style: normal;
  font-weight: normal;
  font-variant: normal;
  text-transform: none;
  font-size: 1.4em;
  line-height: 18px;
  -webkit-font-smoothing: antialiased;
  position: absolute;
  color: #fff;
  background: #017EFA;
    border-radius: 50%;
    text-align: center;
    left: 31.3%;
    top: 50px;
    margin: 0 0 0 -25px;

}



/* Example Media Queries */
@media screen and (max-width: 65.375em) {
  .cbp_tmtimeline > li .cbp_tmtime span:last-child {
    /* font-size: 1.5em; */

  }

.cbp_tmtimeline > li:nth-child(odd) .cbp_tmlabel {
    background: #FFF;
    width: auto;
    height: auto;

}
.cbp_tmtimeline > li {
    position: relative;
    padding: 0px;
}

}
@media screen and (max-width: 767px) {
.cbp_tmtimeline > li .cbp_tmicon{
  display: none;
}
.main {
    padding: 19px;
    margin: 0px;
}
.cbp_tmtimeline > li .cbp_tmtime {
    position: initial;
}
.cbp_tmtimeline > li:nth-child(odd) .cbp_tmtime span:last-child {
    text-align: center;
    padding-bottom: 10px;

}
.cbp_tmtimeline > li .cbp_tmtime span:last-child {
    /* font-size: 1.5em; */
    text-align: center;
    padding-bottom: 10px;
}

}
@media screen and (max-width: 47.2em) {
  .cbp_tmtimeline:before {
    display: none;
  }

  .cbp_tmtimeline > li .cbp_tmtime {
    width: 100%;

  }

  .cbp_tmtimeline > li .cbp_tmtime span {
    text-align: left;
  }

  .cbp_tmtimeline > li .cbp_tmlabel {
    margin: 0 0 30px 0;
    padding: 1em;
    font-weight: 400;
    font-size: 95%;width: fit-content;
  }

  .cbp_tmtimeline > li .cbp_tmlabel:after {
    right: auto;
    left: 20px;
    border-right-color: transparent;
    border-bottom-color: #3594cb;
    top: -20px;
  }

  .cbp_tmtimeline > li:nth-child(odd) .cbp_tmlabel:after {
    border-right-color: transparent;
    border-bottom-color: #6cbfee;
  }

  .cbp_tmtimeline > li .cbp_tmicon {
    position: relative;
    float: right;
    left: auto;
    margin: -55px 5px 0 0px;
  }
}







/* Timeline */

@media screen and (max-width: 768px) {
  .formbold-form-wrapper {
    margin: 0 auto;
    max-width: 70% !important;
    width: 100%;
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    display: none;
}
.formbold-form-wrapper.active {
    display: block;
    position: fixed;
    left: 2% !important;
    z-index: 11111;
}
   .container.main:before {
      left: 8px;
      width: 2px;
   }
   .cbp_tmtimeline > li .cbp_tmicon {

    left: 30.3%;

}
   .cbp_tmtimeline > li .cbp_tmlabel {

  width: auto;}
   .process-table {

    width: 100%;
    /* padding: 10px; */
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
   .process-left {
    display: inherit;
    font-family: 'Roboto', sans-serif;
    border-bottom: 1px solid #ECECEC;
}
.main-left-process {

    width: 100%;
}
.main-right-process {
    text-align: left;
    font-family: 'Roboto', sans-serif;
    width: 100%;
    padding-top: 0px;
    padding-left: 55px;
    padding-bottom: 10px;
}
}



</style>

  <!-- Contact Start -->
  <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-lg-12 py-5 px-5">
                     @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            @if (isset($errors) && count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
              <div class="process-table">
                <div class="process-left">
                  <div class="main-left-process">
                    <i class="fas fa-tint"></i>
                    <h2>Issue Status</h2>
                  </div>

                  <div class="main-right-process">
                    <a href="#">Back to home <i class="fa fa-angle-right"></i></a>
                  </div>
                </div>
                <div class="process-title">
                  <div class="main-process-name">
                    <div class="name-proceess">Ticket Number :  <span>{{ $customerSup->ticket_id}}</span></div>
                    <div class="name-proceess">Name :  <span>{{ $customerSup->first_name}} {{ $customerSup->last_name}}</span></div>
                    <div class="name-proceess">Company :  <span>{{ $customerSup->company}}</span></div>
                    <div class="name-proceess">Subject :  <span>{{ $customerSup->subject}}</span></div>

                    @if($customerSup->delivery_date && $customerSup->delivery_date != "" && $customerSup->delivery_date != "1970-01-01"  && $customerSup->delivery_date != "0000-00-00")
                    <div class="name-proceess">Delivery Date :  <span>{{ date("d M Y",strtotime($customerSup->delivery_date)) }}</span></div>
                    @endif
                    @if($customerSup->file && !empty($customerSup->file))
                    <div class="float-end">
                        <a class="btn btn-primary btn-sm mt-2 mb-2 mr-1" target="_blank" href="{{ asset("storage/support/".$customerSup->file) }}"><i class="fa fa-eye"></i> View Attachment  </a>
                    @endif
                    </div>
                    <!-- <div class="name-proceess">ID :  <span>0215847554</span></div> -->
                  </div>
                  <div class="col-lg-12 p-4">

                  <div class="main">

                <ul class="cbp_tmtimeline">
                    @foreach ($logActivities as $activities)
                    <li>
                        <time class="cbp_tmtime" datetime="2 Jan"><span>{{ date('d M Y',strtotime($activities->created_at))}}</span> </time>
                        <div class="cbp_tmicon cbp_tmicon-screen"></div>
                        <div class="cbp_tmlabel">
                            <h2>{{ $activities->status;  }}</h2>
                            @php $message = config("projectstatus.status_message"); @endphp
                            @if($activities->status == "Assigned")
                                <p> {{ $message?($message[$activities->status]??''):'';  }} To {{ $customerSup->team_members_name }} By {{ $activities->users->name }}</p>
                            @else
                                @if($activities->user_id > 0)
                                    @php $createdBy = $activities->users->name @endphp
                                @else
                                    @php $createdBy = $customerSup->first_name." ".$customerSup->last_name @endphp
                                @endif
                                <p> {{ $message?($message[$activities->status]??''):'';  }}  By {{ $createdBy }}</p>
                            @endif
                        </div>
                    </li>


                    @endforeach
                </ul>
            </div>
                </div>

                </div>
              </div>
            </div>
      </div>

@endsection
