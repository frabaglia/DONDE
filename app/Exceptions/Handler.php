<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;
use App\Exceptions\CustomException;
use App\Exceptions\ImporterException;
use App\Exceptions\CsvException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {   
        

        $list_desings_ids = array('23000', '500','300','310','404');

        if ($exception instanceof CsvException) {
                return response()->view('errors.310', [], 300);
        }
        else if ($exception instanceof CustomException) {
                return response()->view('errors.importador', ['exception' => $exception], 300);    
        }
        else if ($exception instanceof ImporterException) {
               return response()->view('errors.importador', ['exception' => $exception], 300);    
        }
        else if ($exception instanceof QueryException) {
               return response()->view('errors.500', ['exception' => $exception], 300);    

        }
        else if ($exception instanceof HttpException) {
               return response()->view('errors.500', ['exception' => $exception], 300);    

        }
        else if(in_array($exception->getCode(), $list_desings_ids))
        {
           return response()->view('errors.' . $exception->getCode(), ['exception' => $exception]);    
           
        }
        else {
            return parent::render($request, $exception);
        }
        
       
    }
}
