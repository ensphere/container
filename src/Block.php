<?php

namespace Ensphere\Container;

use Illuminate\Http\Request;

class Block
{

    /**
     * @var
     */
    protected $name;

    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @param $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $classes
     */
    public function register( array $classes )
    {
        foreach( $classes as $class ) {
            $this->sections[] = new $class();
        }
    }

    /**
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param Request $request
     * @param array $data
     * @return array
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
     * @param Request $request
     * @param array $data
     */
    public function process( Request $request, $data = [] )
    {
        foreach( $this->sections as $section ) {
            $section->setData( $data );
            $section->process( $request );
        }
    }

}
