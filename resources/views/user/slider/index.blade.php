@extends('layouts.none')

@section('title')
    {{ $title }}
    
@stop
@section('scripts')

@stop
@section('content')
<div class="imag-upload">
	<form action="{{ URL::to('slider_upload')}}" method="post" enctype="multipart/form-data">
		<p class="upload-heading">Select image to upload:</p>
		<input type="file" name="file">
		<input type="submit" name="submit" value="Save" class="btn btn btn-primary">
		<input type="hidden" value="{{ csrf_token() }}" name="_token">
	</form>
</div>
<?php 
	$arr = DB::table("bg_slider")->orderBy('id', 'asc')->get();
	//($arr);
?>
<div class="show-img">
	<table class="post-slide">
		<tr>
			<td>#id</td>
			<td>Image</td>
			<td>Action</td>
		</tr>
		<?php foreach($arr as $eachImg){ ?>
			<tr>
				<td><?php echo $eachImg->id; ?></td>
				<td><img src="uploads/<?php echo $eachImg->img_path; ?>" height="60" width="60"></td>
				<td><a href="img_remove?id=<?php echo $eachImg->id; ?>" class="remove-image"><i class="fa fa-trash"></i>&nbsp;&nbsp;Remove</a></td>
			</tr>

		<?php } ?>
	</table>
</div>
<style type="text/css">
.post-slide{border:none; }
.post-slide tr td, .post-slide th td{padding: 20px;}
.post-slide tr:first-child td{background: #313E4B; color: #fff; padding: 5px 20px;}
.post-slide tr:nth-child(even) td{background:#e8e7e7; }
.remove-image{color: #f00;}
.imag-upload {float: left; width: 100%; text-align: center; padding: 20px; background: #eed5cb; margin-bottom: 30px; margin-top: 20px;}
.imag-upload input{display: inline-block; margin-right: 20px;}
.upload-heading{display: inline-block; margin-right: 20px;}

</style>
@stop

