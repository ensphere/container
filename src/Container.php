<?php namespace Ensphere\Container;

use Illuminate\Http\Request;

class Container {

    /**
     * [$app description]
     * @var [type]
     */
    protected $app;

    /**
     * [$blocks description]
     * @var array
     */
    protected $blocks = [];

    /**
     * [$holdings description]
     * @var array
     */
    protected $holdings = [];

    /**
     * [__construct description]
     * @param [type] $app [description]
     */
    public function __construct( $app )
    {
        $this->app = $app;
    }

    /**
     * Register a new container block
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function register( $name )
    {
        $block = new Block;
        $block->setName( $name );
        $this->blocks[] = $block;
        if( isset( $this->holdings[$name] ) ) {
            $block->register( $this->holdings[$name] );
            unset( $this->holdings[$name] );
        }
        return $block;
    }

    /**
     * [render description]
     * @return [type] [description]
     */
    public function render( $name, $data = [] )
    {
        $viewString = '';
        if( $block = $this->retrieve( $name ) ) {
            foreach( $block->getSections() as $section ) {
                $section->setRegistrar( $name );
                $section->bindData( $data );
                $viewString .= $section->renderView();
            }
        }
        return $viewString;
    }

    /**
     * [bind description]
     * @param  [type] $name    [description]
     * @param  [type] $classes [description]
     * @return [type]          [description]
     */
    public function bind( $name, $classes )
    {
        if( is_string( $classes ) ) {
            $classes = array( $classes );
        }
        if( $block = $this->retrieve( $name ) ) {
            $block->register( $classes );
        } else {
            if( ! isset( $this->holdings[$name] ) ) {
                $this->holdings[$name] = [];
            }
            $this->holdings[$name] = array_merge( $this->holdings[$name], $classes );
        }
    }

    /**
     * [validate description]
     * @param  [type] $routeName [description]
     * @return [type]            [description]
     */
    public function validate( Request $request )
    {
        $validators = [];
        if( $request->method() === 'POST' ) {
            foreach( $this->blocks as $block ) {
                if( $request->input( $block->getName() ) ) {
                    $validators = array_merge( $validators, $block->validate( $request ) );
                }
            }
        }
        return $this->errorsToArray( $validators );
    }

    /**
     * [errorsToArray description]
     * @param  array  $validators [description]
     * @return [type]             [description]
     */
    public function errorsToArray( array $validators )
    {
        $errors = [];
        foreach( array_filter( $validators ) as $validator ) {
            if( $validator->fails() ) {
                $errors = array_merge( $errors, $validator->messages()->toArray() );
            }
        }
        return $errors;
    }

    /**
     * [process description]
     * @param  Request $request [description]
     * @param  array   $data    [description]
     * @return [type]           [description]
     */
    public function process( Request $request, $data = [] )
    {
        foreach( $this->blocks as $block ) {
            if( $request->input( $block->getName() ) ) {
                $block->process( $request, $data );
            }
        }
    }

    /**
     * [retrieve description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function retrieve( $name )
    {
        foreach( $this->blocks as $block ) {
            if( $block->getName() === $name ) {
                return $block;
            }
        }
        return false;
    }

}
