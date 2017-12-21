<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
	    // if ($e instanceof CustomException) {
	    // }		
		return parent::report($e);
	}




	/**
	 * Extract some data from trace exception, in order to locate the problem´s function.
	 *
	 * @param  \Exception  $e
	 * @return String
	 */
	function MakePrettyException(Exception $e) {
	    $trace = $e->getTrace();
	    // dd($trace);
	    $result = 'Exception Text:  "';
	    $result .= $e->getMessage();
	    $result .= '"   @  ';
	   	    
	    if(isset($trace[0]['class']) and ($trace[0]['class'] != '') ) {
	      $result .= $trace[0]['class'];
	      $result .= '->';
	    }
	    

	    $result .= $trace[0]['function'];
	    
	    $result .= '(); ';		
		if(isset($trace[0]['line'])) {
			$result .= ' Start in line ';
	      $result .= $trace[0]['line'];
	      $result .= '.';
	    }
	    
	    return $result;
  }

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($e instanceof CustomException) {
			$formated = $this->MakePrettyException($e);
			// dd($e);
        	return response()->view('errors.22', [
        		'exception'=>$e, 
        		'formated'=> $formated,
        		'sizeProblem'=> $e->dataArray['sizeProblem'],
        		'columns'=> $e->dataArray['columns']
        		], 500);
    	}

    	if ($e instanceof ImporterException) {
			$formated = $this->MakePrettyException($e);
        	return response()->view('errors.importer', ['exception'=>$e, 'formated'=> $formated], 500);
    	}

    	if ($e instanceof CsvException) {
        	return response()->view('errors.310', ['exception'=>$e], 500);
    	}

		return parent::render($request, $e);
	}

}
