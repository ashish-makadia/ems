@foreach ($employeeReports as $eData)
<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2">
        <button id="btnExport" onclick="fnExcelReport();" class="btn btn-primary btn-block float-end" style="font-size:16px"> EXPORT </button>
    </div>
    <hr/>
    <div class="col-md-12 mt-2" style="border-top:solid rgb(212, 211, 211) 1px;">
        <h5 class="mt-4">Employee : </b>{{ $eData['employee_name'] }} </h5><br/>
        {{-- @if(!empty($taskId))
            <h5><b>Task : </b>{{ $taskData->summry }}</h5>
        @endif --}}
    </div>
    <div class="col-md-12" style="overflow-x: scroll;">
        <table class="table table-striped- table-bordered table-hover table-checkable"  id="{{$breadcrumb[0]['name']}}">
            <thead>
                <tr class="heading">
                    <th>{{ __('messages.id')}}</th>
                    <th colspan="3">{{ __('messages.project')}}</th>
                    @foreach($dayArr as $day)
                    <?php
                        $date = date('d/M',strtotime($day));
                        $dayName =  date('D',strtotime($day));
                        $class = "green";
                        if($dayName == "Sat" || $dayName == "Sun"){
                            $class = "red";
                        }
                        ?>
                    <th class="{{ $class }}">{{ $date." (".$dayName.")"}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php $totalHour = []; @endphp
                @if(count($eData['reportData']) > 0)
                    @foreach ($eData['reportData'] as $key => $data)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td colspan="3"><a href="{{route("project.show", ['project' => $data['project_id']]) }}"> {{ $data['project_name'] }} </a></td>
                            @php $a=0; @endphp
                            @foreach ($data['data'] as $k => $dt)
                            <?php
                            $dayName =  date('D',strtotime($dt['log_date']));
                            $class = "green";
                            if($dayName == "Sat" || $dayName == "Sun"){
                            $class = "red";
                            }
                            ?>
                                <td class="{{$class.' '.$dt['log_date']}}">{{ $dt['hour']>0?$dt['hour'].' H':'' }}</th>
                            @php
                                $totalHour[$k] = ($totalHour[$k]??0) + (float)$dt['hour'];
                                // $totalHour[$k] = 0;
                                $a++; @endphp
                            @endforeach
                        </tr>
                    @endforeach
                @else
                <tr>
                    @php $clspn = count($dayArr) + 2; @endphp
                    <td class="text-center" colspan="{{ $clspn }}"> No Worklog reports found</td>
                </tr>
                @endif

            </tbody>
            @if(count($totalHour) > 0)
            <tr>
                <th></th>
                <th colspan="3">Total: </th>
                @foreach ($data['data'] as $k => $dt)
                <?php
                $dayName =  date('D',strtotime($dt['log_date']));
                $class = "green";
                if($dayName == "Sat" || $dayName == "Sun"){
                $class = "red";
                }
                ?>
                <td class="{{$class.' '.$dt['log_date']}}">{{ $totalHour[$k]>0?$totalHour[$k].'H':''; }}</th>

                @endforeach
            </tr>
            @endif
            @if(count($eData['reportData']) > 0)
                <tr class="heading">
                    <th>{{ __('messages.id')}}</th>
                    <th>{{ __('messages.project')}}</th>
                    <th>Issue</th>
                    <th>Comment</th>
                    @foreach($dayArr as $day)
                    <?php
                        $date = date('d/M',strtotime($day));
                        $dayName =  date('D',strtotime($day));
                        $class = "green";
                        if($dayName == "Sat" || $dayName == "Sun"){
                            $class = "red";
                        }
                        ?>
                    <th class="{{ $class }}">{{ $date." (".$dayName.")"}}</th>
                    @endforeach
                </tr>

                <tbody>
                    @php $totalHour = []; @endphp
                    @foreach ($eData['reportData'] as $key => $data)
                    {{-- @php dd($data['project_name']) @endphp --}}

                        <tr>
                            <td rowspan="{{ count($data['task']) }}">{{ $key+1 }}</td>
                            <td rowspan="{{ count($data['task']) }}"><a href="{{route("project.show", ['project' => $data['project_id']]) }}"> {{ $data['project_name'] }} </a></td>

                        @foreach ($data['task'] as $tkey => $tsk)
                        @if (!$loop->first)
                            </tr>
                            </tr>
                        @endif
                        {{-- <tr> --}}
                            <td>{{ $tsk['task_name']}}</td>
                            <td>{!! $tsk['comment'] !!}</td>
                                @foreach ($tsk['days'] as $k => $dt)
                                <?php
                                $dayName =  date('D',strtotime($dt['log_date']));
                                $class = "green";
                                if($dayName == "Sat" || $dayName == "Sun"){
                                $class = "red";
                                }
                                ?>
                                    <td class="{{$class.' '.$dt['log_date']}}">{{ $dt['hour']>0?$dt['hour'].' H':'' }}</th>

                                @endforeach
                        {{-- </tr> --}}
                        @endforeach
                    @endforeach
                </tbody>
            @endif
        </table>
    </div>
</div>
@endforeach
