<?php

namespace SimpleLocator\Integrations;

use SimpleLocator\Integrations\ACF\AdvancedCustomFields;
use SimpleLocator\Integrations\Testimonials\Testimonials;

class IntegrationFactory
{
	public function __construct()
	{
		$this->build();
	}

	/**
	* Build up the Integrations
	*/
	private function build()
	{
		new AdvancedCustomFields;
		new Testimonials;
	}
}