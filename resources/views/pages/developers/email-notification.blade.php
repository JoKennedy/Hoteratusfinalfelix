
<div style="border: 1px solid #ccc; border-radius: 5px; padding: 20px;max-width: 500px">

	<h2>New Status</h2>
	<p>This task has been updated.</p>

	<hr style="color:#ccc"> 

	<h2>{{ $subject }}</h2>

	<b>Developer</b>
	<p class="card">{{ $developer }}</p>

	<b>New Status</b><br>
	<p>
		<span style="color:{{ $status['color'] }};
	    font-weight: bold;">{{ $status['name'] }}</span>
	</p>

	<b>Description</b>:
	<p>{{ $description }}</p>

</div>




