@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <div class="pull-right">
            @if($user_data->hasAccess(['meetings.read']) || $user_data->inRole('admin'))
                <a href="{{ url($type.'/calendar')  }}" class="btn btn-success">
                    <i class="fa fa-calendar"></i> {{ trans('opportunity.calendar') }}</a>
            @endif
            @if($user_data->hasAccess(['meetings.write']) || $user_data->inRole('admin'))
                <a href="{{ url($type.'/create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            @endif
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">radio</i>
                {{ $title }}
            </h4>
                                <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removepanel clickable"></i>
                                </span>
        </div>
        <div class="panel-body">
            <table id="data" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>{{ trans('meeting.meeting_subject') }}</th>
                    <th>{{ trans('meeting.starting_date') }}</th>
                    <th>{{ trans('meeting.ending_date') }}</th>
                    <th>{{ trans('meeting.responsible') }}</th>
                    <th>{{ trans('table.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="popuptext" id="popuptext">asasa</div>

@stop

{{-- Scripts --}}
@section('scripts')
<script type="application/javascript">
	var meeting = new Array();
	var n = [];
	var i;
		<?php $meetingPopup = DB::table('meetings')->select('*')->get(); ?>
		<?php foreach($meetingPopup as $eachMeeting) { ?>
				meeting.push({ "id":"<?php echo $eachMeeting->id;?>", "value": { "subject":"<?php echo $eachMeeting->meeting_subject;?>","description":<?php echo json_encode($eachMeeting->meeting_description);?>,"starting_date":"<?php echo $eachMeeting->starting_date;?>",  "end_date":"<?php echo $eachMeeting->ending_date;?>"} });
		<?php } ?>
		
	function hidePopup(){
		$( "#popuptext" ).removeClass( "show" );
	}
	
	$(document).ready(function () {
		
		 setInterval(function() {
        $('table tbody tr').each(function() {
			
			   x = $(this).find("[title='Edit']").attr('href');
			   a = x.split('/');
			   $(this).attr("id","popup-meeting"+a[6]);
			   $(this).attr("onclick","popupMeetingfunction("+a[6]+",'fst')");
				 //$("<div class='popuptext' id='popuptext'></div>").appendTo(".right-content");	   
		});
    },2000);
	});
	function popupMeetingfunction(id,type){
		//alert('hi');
		var popup = document.getElementById("popuptext");
		popup.classList.toggle("show");
		if(type == 1){
			$( "#popuptext" ).addClass( "show" );
			
			}
		for(i in meeting){
				  n.push(parseInt(meeting[i].id));
				}
			for (i in meeting) {
				if(product[i].id == id){
					var curr = n.indexOf(id);
					var next = curr+1;
					var prev = curr -1;
					var imgPath;
						imgPath = 'http://93.158.221.197/files/public/uploads/products/no-pic-image_1493817948.png';
					var html = '<div class="popup"><div class="part-1"><div class="sub"><h2>'+meeting[i].value.subject+'</h2><i>#'+meeting[i].id+'</i></div><div class="desc" style="text-align:left"><strong><h2>Meeting description: </h2>'+meeting[i].value.description+'</strong></div></div><hr><div class="part-2"><div class="pro-qoh">Start Time: '+meeting[i].value.starting_date+'</div><div class="pro-qa">End Time: '+meeting[i].value.end_date+'</div></div><a class="closed" onclick="hidePopup()" href="">X</a>';
					if(typeof(n[next]) != "undefined"){
						html += '<a id="nxt" onclick="popupMeetingfunction('+n[next]+',1);"><i class="fa fa-chevron-right"></i></a>';
					}
					if(typeof(n[prev]) != "undefined"){
						html += '<a id="prev" onclick="popupMeetingfunction('+n[prev]+',1)"><i class="fa fa-chevron-left"></i></a>';
					}
					
					
					$( ".popuptext").html( html  );
				}
			}
	}
</script>
@stop