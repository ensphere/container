<?php

namespace Ensphere\Container;

use Illuminate\Http\Request;

class Content
{

    /**
     * @var string
     */
    protected $view = '';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $registrar = '';

    /**
     * @param $name
     */
    final public function setRegistrar( $name )
    {
        $this->registrar = $name;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function renderView()
    {
        if( $this->view ) {
            return view( $this->view, $this->data )->render();
        }
    }

    /**
     * @param array $data
     */
    public function setData( array $data )
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public function bindData( array $data )
    {
        $this->data = array_merge( $this->data, $data );
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function validate( Request $request  )
    {
        return true;
    }

    /**
     * @return bool
     */
    public function display()
    {
        return true;
    }

    /**
     * @param Request $request
     */
    public function process( Request $request )
    {

    }

}
