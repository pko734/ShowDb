<?php

namespace ShowDb\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

	if( preg_match('#/stats/(.*)$#', url()->current(), $matches) === 1 ) {
	  if( strpos($request->header('User-Agent'), 'facebookexternalhit') !== false ) {
	      $this->_trickFacebook( $matches[1] );
	      exit(0);
	  }
        }
	return redirect()->guest('login');
    }

    private function _trickFacebook( $username ) {
        $base  = url('/');
        $stats = url('/stats');
	$app_id = env('FACEBOOK_APP_ID');
        echo <<<EOF
<html lang="en"
  <head>
    <title>
      November Blue Database
    </title>
      <meta property="og:url"           content="{$stats}/{$username}" />
      <meta property="og:type"          content="website" />
      <meta property="og:title"         content="November Blue Database Stats: {$username}" />
      <meta property="og:description"   content="Explore and record Avett Brothers show data!" />
      <meta property="og:image"         content="{$base}/img/avett.jpg" />    
      <meta property="fb:app_id"        content="{$app_id}" />
  </head>
  <body/>
</html>
EOF;
    }
}
