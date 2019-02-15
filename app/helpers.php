<?php



function flash($message = null ,$title = null)
{
    \Illuminate\Support\Facades\Log::info('in helpers');
    $f = app('App\Http\Flash');

    if(func_num_args() == 0)
    {
        return $f;
    }

    return $f->info($message,$title);
}

