<?php namespace Ensphere\Container;

use Illuminate\Http\Request;

class Content {

	/**
	 * [$view description]
	 * @var string
	 */
	protected $view = '';

	/**
	 * [$data description]
	 * @var array
	 */
	protected $data = [];

	/**
	 * [$registrar description]
	 * @var string
	 */
	protected $registrar = '';

	/**
	 * [setRegistrar description]
	 * @param [type] $name [description]
	 */
	final public function setRegistrar( $name )
	{
		$this->registrar = $name;
	}

	/**
	 * [renderView description]
	 * @return [type] [description]
	 */
	public function renderView()
	{
		if( $this->view ) {
			return view( $this->view, $this->data )->render();
		}
	}

	/**
	 * [setData description]
	 * @param array $data [description]
	 */
	public function setData( array $data )
	{
		$this->data = $data;
	}

	/**
	 * [bindData description]
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public function bindData( array $data )
	{
		$this->data = array_merge( $this->data, $data );
	}

	/**
	 * [validate description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function validate( Request $request  )
	{
		return true;
	}

	/**
	 * [process description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function process( Request $request )
	{

	}

}