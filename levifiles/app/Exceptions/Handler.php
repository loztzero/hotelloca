<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
// use App\Exceptions\CustomException;
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
		return parent::report($e);
	}

	/**
	 * Ganti ke Whoops error
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */	
	public function render($request, Exception $e)
    {
        if ($this->isHttpException($e))
        {
        	//print_r($e->getStatusCode());
            return $this->renderHttpException($e);
        }

        //tambahin sendiri
        // if ($e instanceOf CustomException)
        // {
        // 	//print_r($e->getStatusCode());
        //     return redirect()->to('exception/read');
        // }

        // ini untuk handle token mismatch exception 
        // if ($e instanceof TokenMismatchException){
        //     //redirect to form an example of how I handle mine
        //     return redirect($request->fullUrl())->with('csrf_error',"Opps! Seems you couldn't submit form for a longtime. Please try again");
        // }

        if (config('app.debug'))
        {
            return $this->renderExceptionWithWhoops($e);
        }

        return parent::render($request, $e);
    }

    /**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	/*public function render($request, Exception $e)
	{
		if ($this->isHttpException($e))
		{
			return $this->renderHttpException($e);
		}
		else
		{
			return parent::render($request, $e);
		}
	}*/

	/**
     * Render an exception using Whoops.
     * 
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }

}
