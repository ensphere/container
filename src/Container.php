<?php

namespace Ensphere\Container;

use Illuminate\Http\Request;

class Container
{

    /**
     * @var
     */
    protected $app;

    /**
     * @var array
     */
    protected $blocks = [];

    /**
     * @var array
     */
    protected $holdings = [];

    /**
     * Container constructor.
     * @param $app
     */
    public function __construct( $app )
    {
        $this->app = $app;
    }

    /**
     * @param $name
     * @return Block
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
     * @param $name
     * @param array $data
     * @return string
     */
    public function render( $name, $data = [] )
    {
        $viewString = '';
        if( $block = $this->retrieve( $name ) ) {
            foreach( $block->getSections() as $section ) {
                $section->setRegistrar( $name );
                $section->bindData( $data );
                if( $section->display() ) {
                    $viewString .= $section->renderView();
                }
            }
        }
        return $viewString;
    }

    /**
     * @param $name
     * @param $classes
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
     * @param Request $request
     * @return array
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
     * @param array $validators
     * @return array
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
     * @param $name
     * @param Request $request
     * @param array $data
     */
    public function process( $name, Request $request, $data = [] )
    {
        foreach( $this->blocks as $block ) {
            if( $request->input( $block->getName() ) ) {
                foreach( $block->getSections() as $section ) {
                    $section->setRegistrar( $name );
                }
                $block->process( $request, $data );
            }
        }
    }

    /**
     * @param $name
     * @return bool|mixed
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
