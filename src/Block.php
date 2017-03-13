<?php namespace Ensphere\Container;

use Illuminate\Http\Request;

class Block {

    /**
     * [$name description]
     * @var [type]
     */
    protected $name;

    /**
     * [$registered description]
     * @var array
     */
    protected $sections = [];

    /**
     * [setName description]
     * @param [type] $name [description]
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * [getName description]
     * @return [type] [description]
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * [register description]
     * @param  [type] $callback [description]
     * @return [type]           [description]
     */
    public function register( array $classes )
    {
        foreach( $classes as $class ) {
            $this->sections[] = new $class();
        }
    }

    /**
     * [getSections description]
     * @return [type] [description]
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * [validate description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function validate( Request $request, $data = [] )
    {
        $validators = [];
        foreach( $this->sections as $section ) {
            $validators[] = $section->validate( $request );
        }
        return $validators;
    }

    /**
     * [process description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function process( Request $request, $data = [] )
    {
        foreach( $this->sections as $section ) {
            $section->setData( $data );
            $section->process( $request );
        }
    }

}
