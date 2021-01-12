<?php 
$task = \App\Tasks::where('id', '=', $id)->first();
?>

{{ $task->get_developer($task->developer_id) }}
