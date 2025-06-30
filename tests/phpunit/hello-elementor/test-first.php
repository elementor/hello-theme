<?php

namespace HelloElementor\Testing;

use ElementorEditorTesting\Elementor_Test_Base;

class Elementor_Test_First extends Elementor_Test_Base {

	public function test_truthness() {
		$this->assertTrue( defined( 'HELLO_ELEMENTOR_TESTS' ) );
	}
}
