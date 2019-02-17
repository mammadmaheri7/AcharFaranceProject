<?php


namespace App\Http;


use Illuminate\Support\Facades\Log;

class Flash
{
    public function create($title,$message,$level)
    {
        Log::info('in Flash.php'.$title.$message.$level);
        session()->flash('flash_message',[
            'title'     =>  $title ,
            'message'   =>  $message,
            'level'     =>  $level,
        ]);

    }

    public function info($title,$message)
    {
        return $this->create($title,$message,'info');
    }

    public function error($title,$message)
    {
        return $this->create($title,$message,'error');
    }

    public function success($title,$message)
    {
        return $this->create($title,$message,'success');
    }



}